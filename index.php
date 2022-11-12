<?php
require __DIR__ . "/lib/connection.php";
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
  <link rel="stylesheet" href="<?php echo $base_url ?>/css/main.css">
  <script defer src="<?php echo $base_url ?>/js/app.js"></script>
</head>

<body>
  <button onclick="window.location.href='<?php echo $base_url ?>/login.php';">login</button>
  <ul>
    <?php
    foreach ($pages as $page) {
      $page_id = $page['page_id'];
      $title = $page['title'];
      echo "<li><a href='$base_url/view-page.php?page=$page_id'>$title</a></li>";
    }
    ?>
  </ul>
  <a href="<?php echo $base_url ?>/add-page.php">Add page</a>
</body>

</html>