<?php
require __DIR__ . "/lib/utils.php";
$base_url = (require __DIR__ . "/config/config.php")['base_url'];

session_start(); // Start the session.

$token = $_SESSION['jwt_token'] ?? null;

if(!checkPermission($token, 'MODERATOR')) {
  header("Location: $base_url/");

  return;
}

$page_id = $_GET['page'];

$pdo = connect_mysql();

$sql = "SELECT * FROM pages WHERE page_id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$page_id]);
$page = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$page) {
  header("Location: $base_url/");
}

$title = $page['title'];
$description = $page['description'];
$content = $page['content'];

$pdo = null;
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/simplemde/latest/simplemde.min.css">
  <script src="https://cdn.jsdelivr.net/simplemde/latest/simplemde.min.js"></script>
  <script defer src="./js/editor.js"></script>
  <title>Document</title>
</head>
<body>
  <h1>Edit <?php echo $title; ?></h1>
  <form action="./handlers/submit-edit-page.php" method="POST">
    <input type="hidden" name="page_id" value="<?php echo $page_id; ?>">
    <input type="text" name="title" placeholder="Title" value="<?php echo $title; ?>">
    <input type="text" name="description" placeholder="Description" value="<?php echo $description; ?>">
    <textarea name="content" id="content-editor" cols="30" rows="10" placeholder="Content"><?php echo $content; ?></textarea>
    <input type="submit" value="Save">
  </form>
</body>
</html>