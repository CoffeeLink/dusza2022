<?php
require __DIR__ . "/lib/utils.php";
$base_url = (require __DIR__ . "/config/config.php")['base_url'];

session_start(); // Start the session.

$token = $_SESSION['jwt_token'] ?? null;

if (!checkPermission($token, 'MODERATOR')) {
  header("Location: $base_url/");

  return;
}

// Might be null if the page is the root page
$parent_page_id = $_GET['parent_page'] ?? null;

if ($parent_page_id != null) {
  $pdo = connect_mysql();

  $sql = "SELECT * FROM pages WHERE page_id = ?";
  $stmt = $pdo->prepare($sql);
  $stmt->execute([$parent_page_id]);
  $parent_page = $stmt->fetch(PDO::FETCH_ASSOC);

  if (!$parent_page) {
    header("Location: $base_url/");
  }

  $parent_page_title = $parent_page['title'];

  $pdo = null;
}
$page_title = "Új oldal";
include __DIR__ . "/header.php";
?>

<div class="row">
    <div class="col-xl-2 col-lg-1 col-sm-0"></div>
    <div class="col-xl-8 col-lg-10 col-sm-12 border border-info rounded bg-info bg-opacity-10 px-4">
        <form action="./handlers/submit-add-page.php" method="POST">
            <h1>
                <?php
        if ($parent_page_id != null) {
          echo "Oldal hozzáadása ehhez: <?= htmlspecialchars($title); ?>";
                } else {
                echo "Oldal hozzáadása";
                }
                ?>
            </h1>

            <input type="text" name="page_id" value="<?php echo htmlspecialchars($page_id); ?>" hidden>
            <div class="mb-3 row">
                <label for="title" class="col-12 col-sm-3 col-form-label">Cím:</label>
                <div class="col-12 col-sm-9">
                    <input type="text" class="form-control" name="title" id="title" placeholder="Cím">
                </div>
            </div>
            <div class="mb-3 row">
                <label for="description" class="col-12 col-sm-3 col-form-label">Leírás:</label>
                <div class="col-12 col-sm-9">
                    <input type="text" class="form-control" name="description" id="description" placeholder="Leírás"
                        required>
                </div>
            </div>
            <div class="mb-3 row">
                <label for="description" class="col-12 col-sm-3 col-form-label">Tartalom:</label>
                <div class="col-12 col-sm-9">

                    <textarea class="form-control" name="content" id="content-editor" placeholder="Tartalom"
                        id="floatingTextarea" rows="20"></textarea>
                </div>
                <input class="btn btn-success teljes my-4 py-2" type="submit" value="Mentés">
            </div>




        </form>

    </div>
    <div class="col-xl-2 col-lg-1 col-sm-0"></div>
</div>