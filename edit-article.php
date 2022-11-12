<?php
require __DIR__ . "/lib/connection.php";
$base_url = (require __DIR__ . "/config/config.php")['base_url'];

session_start(); // Start the session.

$token = $_SESSION['jwt_token'] ?? null;

$article_id = $_GET['article'];

$pdo = connect_mysql();

$sql = "SELECT * FROM articles WHERE article_id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$article_id]);
$article = $stmt->fetch(PDO::FETCH_ASSOC);

if(!checkPermission($_SESSION['jwt_token'], 'MODERATOR') && getUserId($_SESSION['jwt_token']) != $article['author_user_id']) {
  header("Location: $base_url/");

  return;
}

if (!$article) {
  header("Location: $base_url/");
}

$page_id = $article['page_id'];
$title = $article['title'];
$description = $article['description'];
$content = $article['content'];

$pdo = null;
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>
<body>
  <form action="./handlers/submit-edit-article.php" method="POST">
    <input type="hidden" name="article_id" value="<?php echo $article_id; ?>">
    <input type="text" name="title" value="<?php echo $title; ?>">
    <input type="text" name="description" value="<?php echo $description; ?>">
    <textarea name="content" id="" cols="30" rows="10"><?php echo $content; ?></textarea>
    <input type="submit" value="Save">
</body>
</html>