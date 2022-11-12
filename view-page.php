<?php
require 'vendor/autoload.php';
require_once "lib/connection.php";
use Michelf\Markdown;

$page = $_GET['page'];

$pdo = connect_mysql();

$sql = "SELECT * FROM pages WHERE page_id = ?";

$stmt = $pdo->prepare($sql);
$stmt->execute([$page]);
$page = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$page) {
  header('Location: /');
}

$page_id = $page['page_id'];
$title = $page['title'];
$description = $page['description'];
$content = $page['content'];

// Get full route to page by parent_page_id and page_id
// Also save the page_id's in an array
$route = [];
while ($page['parent_page_id'] != null) {
  $sql = "SELECT * FROM pages WHERE page_id = ?";
  $stmt = $pdo->prepare($sql);
  $stmt->execute([$page['parent_page_id']]);
  $page = $stmt->fetch(PDO::FETCH_ASSOC);
  array_push($route, [
    'page_id' => $page['page_id'],
    'title' => $page['title']
  ]);
}

// Reverse the array so the route is in the correct order
$route = array_reverse($route);

// Add the current page to the route
array_push($route, [
  'page_id' => $page_id,
  'title' => $title
]);

// Get the children of the current page
$sql = "SELECT * FROM pages WHERE parent_page_id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$page_id]);
$children = $stmt->fetchAll(PDO::FETCH_ASSOC);

$db = null;
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
  <p>Route:
    <?php
    foreach ($route as $page) {
      echo "<a href='/view-page.php?page={$page['page_id']}'>{$page['title']}</a> / ";
    }
    ?>
  </p>
  <h1>
    <?php echo $title; ?>
  </h1>
  <h2>
    <?php echo $description; ?>
  </h2>
  <p>
    <?php
    echo Markdown::defaultTransform($content);
    ?>
  </p>
  <h3>Childrens</h3>
  <ul>
    <?php
    foreach ($children as $child) {
      echo "<li><a href='/view-page.php?page={$child['page_id']}'>{$child['title']}</a></li>";
    }
    ?>
  </ul>
  <a href="/add-page.php?parent_page=<?php echo $page_id; ?>">Add subpage</a>
  <a href="/edit-page.php?page=<?php echo $page_id; ?>">Edit page</a>
</body>

</html>