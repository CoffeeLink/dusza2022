<?php
require __DIR__ . "/../lib/utils.php";
$base_url = (require __DIR__ . "/../config/config.php")['base_url'];

session_start(); // Start the session.

$token = $_SESSION['jwt_token'] ?? null;

if (!checkPermission($token, 'MODERATOR')) {
  header("Location: $base_url/");

  return;
}

$user_id = getUserId($token);

$page_id = $_POST['page_id'];
$title = $_POST['title'];
$description = $_POST['description'];
$content = $_POST['content'];
$img_url = $_POST['img_url'];
$banner_img_url = $_POST['banner_img_url'];

$pdo = connect_mysql();

$sql = "UPDATE pages SET title = ?, description = ?, content = ?, edited_at = default, edited_by_user_id = ?, img_url = ?, banner_img_url = ? WHERE page_id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$title, $description, $content, $user_id, $img_url, $banner_img_url, $page_id]);

header("Location: $base_url/view-page.php?page=" . $page_id);
?>