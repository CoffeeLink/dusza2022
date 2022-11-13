<?php
require __DIR__ . "/lib/utils.php";
$base_url = (require __DIR__ . "/config/config.php")['base_url'];

session_start(); // Start the session.

$token = $_SESSION['jwt_token'] ?? null;

if(!checkPermission($token, 'MODERATOR')) {
    header("Location: $base_url/");

    return;
}

// Might be null if the page is the root page
$parent_page_id = $_GET['parent_page'] ?? null;

if ($parent_page_id != null) {
  $pdo = connect_mysql();

  $sql = "SELECT * FROM pages WHERE page_id = ?";
  $stmt = $pdo->prepare($sql);
  $stmt->execute([$parent_page_id]);
  $parent_page = $stmt->fetch(PDO::FETCH_ASSOC);

  if (!$parent_page) {
    header("Location: $base_url/");
  }

  $parent_page_title = $parent_page['title'];

  $pdo = null;
}
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
  <title>Add page</title>
</head>

<body>
  <h1>
    <?php
    if ($parent_page_id != null) {
      echo "Add subpage to $parent_page_title";
    } else {
      echo "Add page";
    }
    ?>
  </h1>
  <form action="./handlers/submit-add-page.php" method="post">
    <?php
    if ($parent_page_id != null) {
      echo "<input type='text' name='parent_page_id' value='$parent_page_id' hidden>";
    }
    ?>
    <input type="text" name="title" placeholder="Title">
    <input type="text" name="description" placeholder="Description">
    <textarea name="content" id="content-editor" cols="30" rows="10" placeholder="Content"></textarea>
    <input type="submit" value="Add page">
  </form>
</body>

</html>