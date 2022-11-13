<?php
require __DIR__ . "/../lib/utils.php";
$base_url = (require __DIR__ . "/../config/config.php")['base_url'];

session_start(); // Start the session.

$token = $_SESSION['jwt_token'] ?? null;

if (!checkPermission($token, 'MODERATOR')) {
  header("Location: $base_url/");

  return;
}

$page_id = $_GET['page'];
$visibility = $_GET['visibility'];

$pdo = connect_mysql();

$sql = "UPDATE pages SET is_visible = ? WHERE page_id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$visibility, $page_id]);

header("Location: $base_url/page-pages.php");

$pdo = null;
?>