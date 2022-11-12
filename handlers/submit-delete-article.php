<?php
require __DIR__ . "/../lib/connection.php";

$article_id = $_GET['article'];

$pdo = connect_mysql();

$sql = "SELECT * FROM articles WHERE article_id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$article_id]);
$article = $stmt->fetch(PDO::FETCH_ASSOC);

$page_id = $article['page_id'];

$sql = "DELETE FROM articles WHERE article_id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$article_id]);

header('Location: /view-page.php?page=' . $page_id);

?>