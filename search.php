<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Search by comment text</title>
</head>
<body>
<?php
require_once 'db-connect.php';
require_once 'functions.php';

/**
 * @var $pdo PDO
 */

$comments = [];
if (isset($_GET['text'])) {
    $sanitizedSearchText = htmlspecialchars($_GET['text']);

    guardForMinimumSearchTextSize($sanitizedSearchText);
    $comments = searchInComments($pdo, $sanitizedSearchText);
}
?>

    <p>Поиск по тексту комментария:</p>
    <form action="<?= $_SERVER['PHP_SELF'] ?>" method="get">
        <label>
            <input type="text" name="text">
        </label>
        <input type="submit">
    </form>

<?php if (count($comments) > 0): ?>
    <h1>Comments found:</h1>
    <table>
        <tr>
            <th>post title</th>
            <th>comment</th>
        </tr>
        <?php foreach ($comments as $comment): ?>
            <tr>
                <td><?= $comment['post_title'] ?></td>
                <td><?= $comment['comment_body'] ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
<?php endif; ?>

</body>
</html>
