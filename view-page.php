<?php
require_once __DIR__ . '/vendor/autoload.php';
require __DIR__ . "/lib/utils.php";
$base_url = (require __DIR__ . "/config/config.php")['base_url'];
use Michelf\Markdown;

session_start(); // Start the session.

$token = $_SESSION['jwt_token'] ?? null;

$page = $_GET['page'];

$pdo = connect_mysql();

$sql = "SELECT * FROM pages WHERE page_id = ?";

$stmt = $pdo->prepare($sql);
$stmt->execute([$page]);
$page = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$page) {
  header("Location: $base_url/something-went-wrong.php?code=404");

  return;
}

if (!$page['is_visible'] && !checkPermission($token ?? null, 'MODERATOR')) {
  header("Location: $base_url/something-went-wrong.php?code=403");

  return;
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
$sql = "SELECT * FROM pages WHERE parent_page_id = ? AND is_visible = 1";
$stmt = $pdo->prepare($sql);
$stmt->execute([$page_id]);
$children = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Get the articles of the current page
$sql = "SELECT * FROM articles WHERE page_id = ? AND is_visible = 1";
$stmt = $pdo->prepare($sql);
$stmt->execute([$page_id]);
$articles = $stmt->fetchAll(PDO::FETCH_ASSOC);
$page_title = $title;

$db = null;



include __DIR__ . "/modules/header.php";
?>


<?php
$error = $_GET['error'] ?? null;
if ($error == 'page-has-subpages') {
  echo "This page has subpages, you can't delete it";
}
?>
<div class="row">

  <h1 class="focim">
    <?= htmlspecialchars($title); ?>
  </h1>

  <div class="col-6">
    <h5>Elérési útvonal:
      <?php
      foreach ($route as $page) {
        echo "<a href='./view-page.php?page=" . htmlspecialchars($page['page_id']) . "'>" . htmlspecialchars($page['title']) . "</a> / ";
      }
      ?>
    </h5>
  </div>
  <div class="col-6">
    <?php
    $token = $_SESSION['jwt_token'] ?? null;
    if (checkPermission($token, 'MODERATOR')) {
    ?>
    <a class="btn btn-danger jobbra mx-1"
      href="./handlers/submit-delete-page.php?page=<?php echo htmlspecialchars($page_id); ?>">Oldal törlése</a>
    <a class="btn btn-success jobbra mx-1" href="./edit-page.php?page=<?php echo htmlspecialchars($page_id); ?>">Oldal
      szerkesztése</a>
    <?php
    }
    ?>
    <?php
    if (checkPermission($token, 'EDITOR')) {
    ?>
    <a class="btn btn-primary jobbra mx-1" href="./add-article.php?page=<?php echo htmlspecialchars($page_id); ?>">Cikk
      hozzáadása</a>
    <?php
    }
    ?>
    <?php
    if (checkPermission($token, 'MODERATOR')) {
    ?>
    <a class="btn btn-primary jobbra mx-1"
      href="./add-page.php?parent_page=<?php echo htmlspecialchars($page_id); ?>">Aloldal hozzáadása</a>
    <?php
    }
    ?>

  </div>
</div>

<h3 class="py-3">
  <?php echo htmlspecialchars($description); ?>
</h3>

<div class="p-5 tartalom">
  <?php
  echo Markdown::defaultTransform($content);
  ?>
</div>

<div class="row">
  <?php foreach ($articles as $article) {
    $createdUser = getUserById($article['author_user_id']);
    $createdUserName = $createdUser['last_name'] . ' ' . $createdUser['first_name'];
  ?>
  <div class="col-lg-4 col-md-6 col-sm-12">
    <div class="card">
      <!-- Indexkép -->
      <img class="img-fluid" src="<?php
    if ($article['img_url'] == null || $article['img_url'] == '') {
      echo $base_url . '/img/default_image.png';
    } else {
      echo $article['img_url'];
    }
      ?>" alt="Indexkép">

      <!-- Bejegyzés megjelenő adatai -->
      <h3>
        <?= $article['title'] ?>
      </h3>
      <p class="info">
        <?= $createdUserName ?> | <?= $article['created_at'] ?>
      </p>
      <p class="tartalom">
        <?= $article['description'] ?>
      </p>

      <!-- Tovább olvasom gomb -->
      <div class="col-6">
        <a href="./view-article.php?article=<?= $article['article_id'] ?>">
          <button type="button" class="btn btn-primary tovabb-olvasom">
            Tovább olvasom
          </button>
        </a>
      </div>
    </div>
  </div>
  <?php } ?>
  </ul>
  <?php
  if (count($children) != 0) {
  ?>
  <h3 class="py-3">Aloldalak:</h3>
  <ul class="list-group">
    <?php
    foreach ($children as $child) {
      echo "<li class='list-group-item'><a class='text-decoration-none' href='./view-page.php?page=" . htmlspecialchars($child['page_id']) . "'><b>" . htmlspecialchars($child['title']) . "</b> - " . $child['description'] . "</a></li>";
    }
    ?>
    <?php
  }
    ?>

</div>

<?php
include __DIR__ . "/modules/footer.php";
?>