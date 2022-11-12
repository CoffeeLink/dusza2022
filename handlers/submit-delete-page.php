<?php
require __DIR__ . "/../lib/connection.php";

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

header('Location: /');

$pdo = null;

?>