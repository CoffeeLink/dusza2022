<?php
require __DIR__ . "/../lib/connection.php";

$page_id = $_POST['page_id'];
$title = $_POST['title'];
$description = $_POST['description'];
$content = $_POST['content'];

$pdo = connect_mysql();

$sql = "UPDATE pages SET title = ?, description = ?, content = ?, edited_at = NOW() WHERE page_id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$title, $description, $content, $page_id]);

header('Location: /view-page.php?page=' . $page_id);
?>