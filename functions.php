<?php
function getResource($url): array
{
    $fp = fopen($url, 'r');
    $metaData = stream_get_contents($fp);
    return json_decode($metaData);
}

function insertPost($id, $title, $body): bool
{
    global $connect;

    if ($query = $connect->query('SELECT id 
                                           FROM posts 
                                          WHERE id=' . $id)) {
        if ($query->num_rows != 0) {
            return false;
        }
    }

    $sql = 'INSERT INTO posts(id, title, body) 
            VALUES (?, ?, ?)';
    $statement = $connect->prepare($sql);
    return $statement->execute([$id, $title, $body]);
}

function insertComment($id, $body, $postId): bool
{
    global $connect;

    if ($query = $connect->query('SELECT id 
                                           FROM comments 
                                          WHERE id=' . $id)) {
        if ($query->num_rows > 0) {
            return false;
        }
    }

    $sql = 'INSERT INTO comments(id, body, post_id) 
            VALUES(?, ?, ?)';
    $statement = $connect->prepare($sql);
    return $statement->execute([$id, $body, $postId]);
}


function searchInComments($text): array
{
    global $connect;

    $text = "%$text%";
    $query = $connect->prepare('SELECT comments.id as comment_id, 
                                              p.title as post_title,
                                              comments.body as comment_body 
                                         FROM comments 
                                         JOIN posts p on p.id = comments.post_id
                                        WHERE comments.body LIKE ?');
    $query->execute([$text]);
    return $query->get_result()->fetch_all(MYSQLI_ASSOC);
}

function checkForSearchTextLength($text){
    if (strlen($text) < 3) {
        die('Search text must be 3 or more symbols');
    }
    return true;
}