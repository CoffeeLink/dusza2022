<?php
require __DIR__ . "/lib/connection.php";
$base_url = (require __DIR__ . "/config/config.php")['base_url'];

$page_id = $_GET['page'];

$pdo = connect_mysql();

// Get page data
$sql = "SELECT * FROM pages WHERE page_id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$page_id]);
$page = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$page) {
  header("Location: $base_url/");
}

$title = $page['title'];
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
  <h1>Add article</h1>
  <form action="./handlers/submit-add-article.php" method="post">
    <input type="text" name="page_id" value="<?php echo $page_id; ?>" hidden>
    <input type="text" name="title" placeholder="Title">
    <input type="text" name="description" placeholder="Description">
    <textarea name="content" id="content-editor" cols="30" rows="10" placeholder="Content"></textarea>
    <input type="submit" value="Add article">
  </form>
</body>

</html>