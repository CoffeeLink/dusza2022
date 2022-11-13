<?php
require_once __DIR__ . '/vendor/autoload.php';
require __DIR__ . "/lib/utils.php";
$base_url = (require __DIR__ . "/config/config.php")['base_url'];
use Michelf\Markdown;

$article = $_GET['article'];

$pdo = connect_mysql();

$token = $_SESSION['jwt_token'] ?? null;

$sql = "SELECT * FROM articles WHERE article_id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$article]);
$article = $stmt->fetch(PDO::FETCH_ASSOC);
$article_id = $article['article_id'];

if (!$article) {
  header("Location: $base_url/something-went-wrong.php?code=404");

  return;
}

if (!$article['is_visible'] && !checkPermission($token ?? null, 'MODERATOR')) {
  header("Location: $base_url/something-went-wrong.php?code=403");

  return;
}

// Get the full route to the article through pages
// Also save the page_id's in an array
$route = [];
while ($article['page_id'] != null) {
  $sql = "SELECT * FROM pages WHERE page_id = ?";
  $stmt = $pdo->prepare($sql);
  $stmt->execute([$article['page_id']]);
  $page = $stmt->fetch(PDO::FETCH_ASSOC);
  array_push($route, [
    'page_id' => $page['page_id'],
    'title' => $page['title']
  ]);
  $article['page_id'] = $page['parent_page_id'];
}

$pdo = null;

// Reverse the array so the route is in the correct order
$route = array_reverse($route);

include __DIR__ . "/modules/header.php";
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
    <?php echo htmlspecialchars($article['title']); ?>
  </h1>
  <p>
    <?php echo htmlspecialchars($article['description']) ?>
  </p>
  <div>
    <?php echo Markdown::defaultTransform($article['content']) ?>
  </div>
  <?php
  $token = $_COOKIE['jwt_token'] ?? null;

  if (checkPermission($token, 'MODERATER')) {
  ?>
  <a href="./edit-article.php?article=<?php echo htmlspecialchars($article['article_id']) ?>">Edit article</a>
  <a href="./handlers/submit-delete-article.php?article=<?php echo htmlspecialchars($article['article_id']) ?>">Delete
    article</a>
  <?php
  }
  ?>

  <?php
  include __DIR__ . "/modules/footer.php";
  ?>
</body>

</html>