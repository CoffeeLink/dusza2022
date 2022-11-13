<?php
require __DIR__ . "/lib/utils.php";
$base_url = (require __DIR__ . "/config/config.php")['base_url'];

session_start(); // Start the session.

$token = $_SESSION['jwt_token'] ?? null;

if (!checkPermission($token, 'MODERATOR')) {
  header("Location: https://www.youtube.com/watch?v=dQw4w9WgXcQ");

  return;
}

$page_id = $_GET['page'];

$pdo = connect_mysql();

$sql = "SELECT * FROM pages WHERE page_id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$page_id]);
$page = $stmt->fetch(PDO::FETCH_ASSOC);
$page_title = "Szerkesztés";

if (!$page) {
  header("Location: $base_url/");
}

$title = $page['title'];
$description = $page['description'];
$content = $page['content'];

$pdo = null;
include __DIR__ . "/header.php";
?>

<body>
  <div class="row">
    <div class="col-xl-2 col-lg-1 col-sm-0"></div>
    <div class="col-xl-8 col-lg-10 col-sm-12 border border-info rounded bg-info bg-opacity-10 px-4">
      <form action="./handlers/submit-edit-page.php" method="POST">
        <h1>Szerkesztés:
          <?php echo htmlspecialchars($title); ?>
        </h1>

        <input type="hidden" name="page_id" value="<?php echo htmlspecialchars($page_id); ?>">
        <div class="mb-3 row">
          <label for="title" class="col-12 col-sm-3 col-form-label">Cím:</label>
          <div class="col-12 col-sm-9">
            <input type="text" class="form-control" name="title" id="title" placeholder="Cím"
              value="<?php echo htmlspecialchars($title); ?>">
          </div>
        </div>
        <div class="mb-3 row">
          <label for="description" class="col-12 col-sm-3 col-form-label">Leírás:</label>
          <div class="col-12 col-sm-9">
            <input type="text" class="form-control" name="description" id="description" placeholder="••••••••"
              value="<?php echo htmlspecialchars($description); ?>" required>
          </div>
        </div>
        <div class="mb-3 row">
          <label for="description" class="col-12 col-sm-3 col-form-label">Tartalom:</label>
          <div class="col-12 col-sm-9">
            <textarea class="form-control" name="content" id="content-editor" placeholder="Tartalom"
              id="floatingTextarea" rows="20"><?php echo htmlspecialchars($content); ?></textarea>
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