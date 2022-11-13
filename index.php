<?php
require __DIR__ . "/lib/utils.php";
$base_url = (require __DIR__ . "/config/config.php")['base_url'];

$pdo = connect_mysql();

// Get all root pages
$sql = "SELECT * FROM pages WHERE parent_page_id IS NULL";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$pages = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>main Page</title>
  <link rel="stylesheet" href="./css/main.css">
  <script defer src="./js/app.js"></script>
</head>

<body>
  <button onclick="window.location.href='./login.php';">login</button>
  <ul>
    <?php
    foreach ($pages as $page) {
      $page_id = $page['page_id'];
      $title = $page['title'];
      echo "<li><a href='./view-page.php?page=$page_id'>$title</a></li>";
    }
    ?>
  </ul>
  <a href="./add-page.php">Add page</a>
</body>

</html>