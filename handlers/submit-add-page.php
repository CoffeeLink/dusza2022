<?php

require __DIR__ . "/../lib/connection.php";

$title = $_POST['title'];
$description = $_POST['description'];
$content = $_POST['content'];

$pdo = connect_mysql();

// Insert data into database
$sql = "INSERT INTO pages (parent_page_id, title, description, content, is_visible, created_at, edited_at, created_by_user_id, edited_by_user_id) VALUES (NULL, ?, ?, ?, 1, NOW(), NOW(), 1, 1)";
$stmt = $pdo->prepare($sql);
$stmt->execute([$title, $description, $content]);



?>