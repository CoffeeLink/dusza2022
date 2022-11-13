<?php
$base_url = (require __DIR__ . "/../config/config.php")['base_url'];
require __DIR__ . "/../lib/utils.php";

session_start(); // Start the session.

$token = $_SESSION['jwt_token'] ?? null;

$article_id = $_GET['article'];

$pdo = connect_mysql();

$sql = "SELECT * FROM articles WHERE article_id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$article_id]);
$article = $stmt->fetch(PDO::FETCH_ASSOC);

if(!checkPermission($token, 'EDITOR') && getUserId($_SESSION['jwt_token']) != $article['author_user_id']) {
  header("Location: $base_url/something-went-wrong.php?errorTitle=You%20do%20not%20have%20permission%20to%20delete%20this%20article.&errorDescription=You%20do%20not%20have%20permission%20to%20delete%20this%20article.&errorCode=403");

  return;
}

$page_id = $article['page_id'];

$sql = "DELETE FROM articles WHERE article_id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$article_id]);

header("Location: $base_url/view-page.php?page=" . $page_id);

?>