<?php
$base_url = (require __DIR__ . "/../config/config.php")['base_url'];
require __DIR__ . "/../lib/connection.php";

session_start(); // Start the session.

$token = $_SESSION['jwt_token'] ?? null;

if(!checkPermission($_SESSION['jwt_token'], 'MODERATOR')) {
    header("Location: $base_url/");

    return;
}

$page_id = $_GET['page'];

$pdo = connect_mysql();

// Check if page has subpages
$sql = "SELECT * FROM pages WHERE parent_page_id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$page_id]);
$children = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (count($children) > 0) {
  header('Location: /view-page.php?page=' . $page_id . '&error=page-has-subpages');
}

$sql = "DELETE FROM pages WHERE page_id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$page_id]);

header("Location: $base_url/");

$pdo = null;

?>