<?php
require_once 'vendor/autoload.php';
require __DIR__ . "/lib/connection.php";
$base_url = (require __DIR__ . "/config/config.php")['base_url'];
use Michelf\Markdown;

$article = $_GET['article'];

$pdo = connect_mysql();

$sql = "SELECT * FROM articles WHERE article_id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$article]);
$article = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$article) {
  header("Location: $base_url/");
}

$page_id = $article['page_id'];
$title = $article['title'];
$description = $article['description'];
$content = $article['content'];

// Get the full route
$route = [];
while ($page_id != null) {
  $sql = "SELECT * FROM pages WHERE page_id = ?";
  $stmt = $pdo->prepare($sql);
  $stmt->execute([$page_id]);
  $page = $stmt->fetch(PDO::FETCH_ASSOC);
  array_push($route, [
    'page_id' => $page['page_id'],
    'title' => $page['title']
  ]);
  $page_id = $page['parent_page_id'];
}

// Reverse the array so the route is in the correct order
$route = array_reverse($route);

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
  <h1>Route:
    <?php
    foreach ($route as $page) {
      echo "<a href='$base_url/view-page.php?page={$page['page_id']}'>{$page['title']}</a> -> ";
    }
    echo $title;
  ?>
  </h1>
  <h1>
    <?php echo $title ?>
  </h1>
  <p>
    <?php echo $description ?>
  </p>
  <div>
    <?php echo Markdown::defaultTransform($content) ?>
  </div>
  <a href="<?php echo $base_url ?>/edit-article.php?article=<?php echo $article['article_id'] ?>">Edit article</a>
  <a href="<?php echo $base_url ?>/handlers/submit-delete-article.php?article=<?php echo $article['article_id'] ?>">Delete article</a>
</body>

</html>