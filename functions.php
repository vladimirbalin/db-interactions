<?php
function getResource($url): array
{
    $fp = fopen($url, 'r');
    $metaData = stream_get_contents($fp);
    return json_decode($metaData);
}

function handlePost($pdo, $id, $title, $body): bool
{
    if (dbHasPost($pdo, $id)) return false;
    return insertPost($pdo, $id, $title, $body);
}

function dbHasPost($connect, $id)
{
    $sql = 'SELECT id 
              FROM posts 
             WHERE id=?';
    $statement = $connect->prepare($sql);
    if (
        $statement->execute([$id]) &&
        $statement->rowCount() > 0
    ) {
        return true;
    }
    return false;
}

function insertPost($pdo, $id, $title, $body): bool
{
    $sql = 'INSERT INTO posts(id, title, body) 
            VALUES (?, ?, ?)';
    $statement = $pdo->prepare($sql);
    return $statement->execute([$id, $title, $body]);
}

function handleComment($pdo, $id, $body, $postId): bool
{
    if (dbHasComment($pdo, $id)) return false;
    return insertComment($pdo, $id, $body, $postId);
}

function dbHasComment($pdo, $id)
{
    $sql = 'SELECT id 
              FROM comments 
             WHERE id=?';
    $statement = $pdo->prepare($sql);
    if (
        $statement->execute([$id]) &&
        $statement->rowCount() > 0
    ) {
        return true;
    }
    return false;
}

function insertComment($pdo, $id, $body, $postId): bool
{
    $sql = 'INSERT INTO comments(id, body, post_id) 
            VALUES(?, ?, ?)';
    $statement = $pdo->prepare($sql);
    return $statement->execute([$id, $body, $postId]);
}


function searchInComments(PDO $pdo, $text): array
{
    $text = "%$text%";
    $query = $pdo->prepare('SELECT comments.id as comment_id, 
                                   p.title as post_title,
                                   comments.body as comment_body 
                              FROM comments 
                              JOIN posts p on p.id = comments.post_id
                             WHERE comments.body LIKE ?');
    $query->execute([$text]);
    return $query->fetchAll(PDO::FETCH_ASSOC);
}

function guardForMinimumSearchTextSize($text)
{
    if (mb_strlen($text) < 3) {
        die('Search text must be 3 or more symbols');
    }
    return true;
}