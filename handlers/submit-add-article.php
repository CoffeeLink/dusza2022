<?php
require __DIR__ . "/../lib/connection.php";

$page_id = $_POST['page_id'];
$title = $_POST['title'];
$description = $_POST['description'];
$content = $_POST['content'];

$pdo = connect_mysql();

$sql = "INSERT INTO articles (page_id, title, description, content, author_user_id, is_visible, created_at, edited_at, edited_by_user_id) VALUES (?, ?, ?, ?, 1, 0, NOW(), NOW(), 1)";
$stmt = $pdo->prepare($sql);
$stmt->execute([$page_id, $title, $description, $content]);

header('Location: /view-page.php?page=' . $page_id);

$pdo = null;

?>