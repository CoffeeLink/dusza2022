<?php
require_once __DIR__ . '/vendor/autoload.php';
require __DIR__ . "/lib/utils.php";
$base_url = (require __DIR__ . "/config/config.php")['base_url'];
use Michelf\Markdown;

$page = $_GET['page'];

$pdo = connect_mysql();

$sql = "SELECT * FROM pages WHERE page_id = ?";

$stmt = $pdo->prepare($sql);
$stmt->execute([$page]);
$page = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$page) {
  header("Location: $base_url/");
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

// Get the articles of the current page
$sql = "SELECT * FROM articles WHERE page_id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$page_id]);
$articles = $stmt->fetchAll(PDO::FETCH_ASSOC);

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
  <h1>
    <?php
    $error = $_GET['error'] ?? null;
    if ($error == 'page-has-subpages') {
      echo "This page has subpages, you can't delete it";
    }
    ?>
    <p>Route:
      <?php
      foreach ($route as $page) {
        echo "<a href='./view-page.php?page={$page['page_id']}'>{$page['title']}</a> / ";
      }
      ?>
    </p>
    <h1>
      <?php echo $title; ?>
    </h1>
    <h2>
      <?php echo $description; ?>
    </h2>
    <div>
      <?php
      echo Markdown::defaultTransform($content);
      ?>
    </div>
    <h3>Childrens</h3>
    <ul>
      <?php
      foreach ($children as $child) {
        echo "<li><a href=./view-page.php?page={$child['page_id']}'>{$child['title']}</a></li>";
      }
      ?>
    </ul>
    <a href="./add-page.php?parent_page=<?php echo $page_id; ?>">Add subpage</a>
    <a href="./edit-page.php?page=<?php echo $page_id; ?>">Edit page</a>
    <a href="./handlers/submit-delete-page.php?page=<?php echo $page_id; ?>">Delete page</a>
    <h3>Articles</h3>
    <ul>
      <?php
      foreach ($articles as $article) {
        echo "<li><a href='./view-article.php?article={$article['article_id']}'>{$article['title']}</a></li>";
      }
      ?>
    </ul>
    <a href="./add-article.php?page=<?php echo $page_id; ?>">Add article</a>
</body>

</html>