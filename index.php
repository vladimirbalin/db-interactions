<?php
require_once 'functions.php';
require_once 'db-connect.php';

/**
 * @var $pdo PDO
 */

$posts = getResource("https://jsonplaceholder.typicode.com/posts");
$comments = getResource("https://jsonplaceholder.typicode.com/comments");

$insertedPostsCount = 0;
foreach ($posts as $post) {
    if (handlePost($pdo, $post->id, $post->title, $post->body)) {
        $insertedPostsCount++;
    }
}

$insertedCommentsCount = 0;
foreach ($comments as $comment) {
    if (handleComment($pdo, $comment->id, $comment->body, $comment->postId)) {
        $insertedCommentsCount++;
    }
}

echo "Загружено $insertedPostsCount записей и $insertedCommentsCount комментариев в базу данных";