<?php
require_once __DIR__ . '/vendor/autoload.php';
require __DIR__ . "/lib/utils.php";
$base_url = (require __DIR__ . "/config/config.php")['base_url'];
use Michelf\Markdown;

$article = $_GET['article'];

$pdo = connect_mysql();

$sql = "SELECT * FROM articles WHERE article_id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$article]);
$article = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$article) {
  header("Location: $base_url/something-went-wrong.php?code=404");

  return;
}

// Get the full route
$route = [];
$page_id = $article['page_id'];
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
      echo "<a href='./view-page.php?page=" . htmlspecialchars($page['page_id']) . "'>" . htmlspecialchars($page['title']) . "</a> -> ";
    }
    echo htmlspecialchars($article['title']);
    ?>
  </h1>
  <h1>
    <?php echo htmlspecialchars($article['page_id']) ?>
  </h1>
  <p>
    <?php echo htmlspecialchars($article['description']) ?>
  </p>
  <div>
    <?php echo Markdown::defaultTransform($article['content']) ?>
  </div>
  <a href="./edit-article.php?article=<?php echo htmlspecialchars($article['article_id']) ?>">Edit article</a>
  <a href="./handlers/submit-delete-article.php?article=<?php echo htmlspecialchars($article['article_id']) ?>">Delete article</a>
</body>

</html>