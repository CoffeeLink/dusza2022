<?php
$base_url = (require __DIR__ . "/../config/config.php")['base_url'];
require __DIR__ . "/../lib/utils.php";

session_start(); // Start the session.

$token = $_SESSION['jwt_token'] ?? null;

$article_id = $_POST['article_id'];
$title = $_POST['title'];
$description = $_POST['description'];
$content = $_POST['content'];
$img_url = $_POST['img_url'];

$pdo = connect_mysql();

$sql = "SELECT * FROM articles WHERE article_id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$article_id]);
$article = $stmt->fetch(PDO::FETCH_ASSOC);

if(!checkPermission($token, 'MODERATOR') && getUserId($token) != $article['author_user_id']) {
    header("Location: $base_url/");

    return;
}

$sql = "UPDATE articles SET title = ?, description = ?, content = ?, edited_at = NOW(), edited_by_user_id = ?, img_url = ? WHERE article_id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$title, $description, $content, getUserId($token), $img_url, $article_id]);

header("Location: $base_url/view-article.php?article=" . $article_id);

$pdo = null;
?>