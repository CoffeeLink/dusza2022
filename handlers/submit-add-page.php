<?php
require __DIR__ . "/../lib/connection.php";
$base_url = (require __DIR__ . "/../config/config.php")['base_url'];

session_start(); // Start the session.

$token = $_SESSION['jwt_token'] ?? null;

if(!checkPermission($_SESSION['jwt_token'], 'MODERATOR')) {
    header("Location: $base_url/");

    return;
}

$pdo = connect_mysql();

$parent_page_id = $_POST['parent_page_id'] ?? null;
$title = $_POST['title'];
$description = $_POST['description'];
$content = $_POST['content'];

$sql = "INSERT INTO pages (parent_page_id, title, description, content, is_visible, created_at, edited_at, created_by_user_id, edited_by_user_id) VALUES (?, ?, ?, ?, 0, NOW(), NOW(), 1, 1)";
$stmt = $pdo->prepare($sql);
$stmt->execute([$parent_page_id, $title, $description, $content]);


header("Location: $base_url/view-page.php?page=" . $pdo->lastInsertId());

$pdo = null;
?>