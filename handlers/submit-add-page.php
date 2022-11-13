<?php
require __DIR__ . "/../lib/utils.php";
$base_url = (require __DIR__ . "/../config/config.php")['base_url'];

session_start(); // Start the session.

$token = $_SESSION['jwt_token'] ?? null;

if(!checkPermission($token, 'MODERATOR')) {
    header("Location: $base_url/");

    return;
}

$user_id = getUserId($token);

$parent_page_id = $_POST['parent_page_id'] ?? null;
if ($parent_page_id == "root") {
  $parent_page_id = null;
}
$title = $_POST['title'];
$description = $_POST['description'];
$content = $_POST['content'];
$img_url = $_POST['img_url'];
$banner_img_url = $_POST['banner_img_url'];

$pdo = connect_mysql();

$sql = "INSERT INTO pages (parent_page_id, title, description, content, is_visible, created_at, edited_at, created_by_user_id, edited_by_user_id, img_url, banner_img_url) VALUES (?, ?, ?, ?, 0, NOW(), NOW(), ?, ?, ?, ?)";
$stmt = $pdo->prepare($sql);
$stmt->execute([$parent_page_id, $title, $description, $content, $user_id, $user_id, $img_url, $banner_img_url]);

header("Location: $base_url/view-page.php?page=" . $pdo->lastInsertId());

$pdo = null;
?>