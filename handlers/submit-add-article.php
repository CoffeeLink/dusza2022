<?php
require __DIR__ . "/../lib/utils.php";
$base_url = (require __DIR__ . "/../config/config.php")['base_url'];

session_start(); // Start the session.

$token = $_SESSION['jwt_token'] ?? null;

if(!checkPermission($token, 'EDITOR')) {
    header("Location: $base_url/");

    return;
}

$user_id = getUserId($token);

$page_id = $_POST['page_id'];
$title = $_POST['title'];
$description = $_POST['description'];
$content = $_POST['content'];
$img_url = $_POST['img_url'];

$pdo = connect_mysql();

$sql = "INSERT INTO articles (page_id, title, description, content, author_user_id, is_visible, created_at, edited_at, edited_by_user_id, img_url) VALUES (?, ?, ?, ?, ?, 0, default, default, ?, ?)";
$stmt = $pdo->prepare($sql);
$stmt->execute([$page_id, $title, $description, $content, $user_id, $user_id, $img_url]);

header("Location: $base_url/view-page.php?page=" . $page_id);

$pdo = null;

?>