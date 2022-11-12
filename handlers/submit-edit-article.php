<?php
$base_url = (require __DIR__ . "/../config/config.php")['base_url'];
require __DIR__ . "/../lib/connection.php";

session_start(); // Start the session.

$token = $_SESSION['jwt_token'] ?? null;

$article_id = $_POST['article_id'];
$title = $_POST['title'];
$description = $_POST['description'];
$content = $_POST['content'];

$pdo = connect_mysql();

$sql = "UPDATE articles SET title = ?, description = ?, content = ?, edited_at = NOW() WHERE article_id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$title, $description, $content, $article_id]);

if(!checkPermission($_SESSION['jwt_token'], 'MODERATOR') && getUserId($_SESSION['jwt_token']) != $article['author_user_id']) {
    header("Location: $base_url/");

    return;
}

header("Location: $base_url/view-article.php?article=" . $article_id);

$pdo = null;
?>