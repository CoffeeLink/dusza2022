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
  header("Location: $base_url/something-went-wrong.php?errorTitle=Page%20not%20found&errorDescription=The%20page%20you%20are%20looking%20for%20does%20not%20exist.&errorCode=404");
}

$page_id = $article['page_id'];
$title = $article['title'];
$description = $article['description'];
$content = $article['content'];
$page_title = $title;

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

include __DIR__ . "/header.php";
?>


<div class="row">

    <h1 class="focim"><?= htmlspecialchars($title); ?></h1>

    <div class="col-6">
        <h5>Elérési útvonal:
            <?php
      foreach ($route as $page) {
        echo "<a class='text-decoration-none' href='./view-page.php?page=" . htmlspecialchars($page['page_id']) . "'>" . htmlspecialchars($page['title']) . "</a> / ";
      }
      echo htmlspecialchars($article['title']);
      ?>
        </h5>
    </div>
    <div class="col-6">
        <a class="btn btn-danger jobbra mx-1"
            href="./handlers/submit-delete-article.php?article=<?php echo htmlspecialchars($article['article_id']) ?>">Bejegyzés
            törlése</a>
        <a class="btn btn-primary jobbra mx-1"
            href="./edit-article.php?article=<?php echo htmlspecialchars($article['article_id']) ?>">Bejegyzés
            szerkesztése</a>

    </div>
</div>

<h4 class="py-3">
    <?php echo htmlspecialchars($description); ?>
</h4>

<div class="p-5 tartalom">
    <?php
  echo Markdown::defaultTransform($content);
  ?>
</div>

<?php
include __DIR__ . "/footer.php";
?>