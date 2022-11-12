<?php
require __DIR__ . "/../lib/connection.php";

$pdo = connect_mysql();

$parent_page_id = $_POST['parent_page_id'] ?? null;
$title = $_POST['title'];
$description = $_POST['description'];
$content = $_POST['content'];

$sql = "INSERT INTO pages (parent_page_id, title, description, content, is_visible, created_at, edited_at, created_by_user_id, edited_by_user_id) VALUES (?, ?, ?, ?, 1, NOW(), NOW(), 1, 1)";
$stmt = $pdo->prepare($sql);
$stmt->execute([$parent_page_id, $title, $description, $content]);

header('Location: /view-page.php?page=' . $pdo->lastInsertId());

$pdo = null;
?>
