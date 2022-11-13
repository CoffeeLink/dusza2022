<?php
require __DIR__ . "/lib/utils.php";
$base_url = (require __DIR__ . "/config/config.php")['base_url'];

session_start(); // Start the session.

$token = $_SESSION['jwt_token'] ?? null;

$article_id = $_GET['article'];

$pdo = connect_mysql();

$sql = "SELECT * FROM articles WHERE article_id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$article_id]);
$article = $stmt->fetch(PDO::FETCH_ASSOC);

if (!checkPermission($token, 'MODERATOR') && getUserId($_SESSION['jwt_token']) != $article['author_user_id']) {
  header("Location: $base_url/something-went-wrong.php?errorTitle=Permission%20denied&errorDescription=You%20do%20not%20have%20permission%20to%20edit%20this%20article.&errorCode=403");

  return;
}

if (!$article) {
  header("Location: $base_url/something-went-wrong.php?errorTitle=Article%20not%20found&errorDescription=The%20article%20you%20are%20looking%20for%20does%20not%20exist.&errorCode=404");
}

$page_title = "Szerkesztés";

$pdo = null;
include __DIR__ . "/header.php";
?>
<div class="row">
  <div class="col-xl-2 col-lg-1 col-sm-0"></div>
  <div class="col-xl-8 col-lg-10 col-sm-12 border border-info rounded bg-info bg-opacity-10 px-4">
    <form action="./handlers/submit-edit-article.php" method="POST">
      <h1>Szerkesztés:
        <?= htmlspecialchars($article["title"]); ?>
      </h1>

      <input type="hidden" name="article_id" value="<?= htmlspecialchars($article_id); ?>">
      <div class="mb-3 row">
        <label for="title" class="col-12 col-sm-3 col-form-label">Cím:</label>
        <div class="col-12 col-sm-9">
          <input type="text" class="form-control" name="title" id="title" placeholder="Cím"
            value="<?= htmlspecialchars($article["title"]); ?>">
        </div>
      </div>
      <div class="mb-3 row">
        <label for="description" class="col-12 col-sm-3 col-form-label">Leírás:</label>
        <div class="col-12 col-sm-9">
          <input type="text" class="form-control" name="description" id="description" placeholder="Leírás"
            value="<?= htmlspecialchars($article["description"]); ?>" required>
        </div>
      </div>
      <div class="mb-3 row">
        <label for="img_url" class="col-12 col-sm-3 col-form-label">Kép url:</label>
        <div class="col-12 col-sm-9">
          <input type="url" class="form-control" name="img_url" id="img_url"
            placeholder="https://www.example.com/image.jpg" value="<?= htmlspecialchars($article["img_url"]); ?>">
        </div>
      </div>
      <div class="mb-3 row">
        <label for="description" class="col-12 col-sm-3 col-form-label">Tartalom:</label>
        <div class="col-12 col-sm-9">
          <textarea class="form-control" name="content" id="content-editor" placeholder="Tartalom" id="floatingTextarea"
            rows="20"><?= htmlspecialchars($article["content"]); ?></textarea>
        </div>
        <input class="btn btn-success teljes my-4 py-2" type="submit" value="Mentés">
      </div>
    </form>
  </div>
  <div class="col-xl-2 col-lg-1 col-sm-0"></div>
</div>

<?php
include __DIR__ . "./footer.php";
?>