<?php
require __DIR__ . "/../lib/utils.php";
$base_url = (require __DIR__ . "/../config/config.php")['base_url'];

session_start(); // Start the session.

$token = $_SESSION['jwt_token'] ?? null;

if (!checkPermission($token, 'MODERATOR')) {
  header("Location: $base_url/");

  return;
}

$article_id = $_GET['article'];
$visibility = $_GET['visibility'];

$pdo = connect_mysql();

$sql = "UPDATE articles SET is_visible = ? WHERE article_id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$visibility, $article_id]);

header("Location: $base_url/page-articles.php");

$pdo = null;
?>