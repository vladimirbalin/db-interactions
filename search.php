<?php
require_once 'db-connect.php';
require_once 'functions.php';

$comments = [];
if (isset($_GET['text'])) {
    $sanitizedSearchText = htmlspecialchars($_GET['text']);

    checkForSearchTextLength($sanitizedSearchText);
    $comments = searchInComments($sanitizedSearchText);
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