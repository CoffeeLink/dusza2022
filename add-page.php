<?php
require __DIR__ . "/lib/utils.php";
$base_url = (require __DIR__ . "/config/config.php")['base_url'];

session_start(); // Start the session.

$token = $_SESSION['jwt_token'] ?? null;

if (!checkPermission($token, 'MODERATOR')) {
  header("Location: $base_url/something-went-wrong.php?code=403");

  return;
}

// Might be null if the page is the root page
$parent_page_id = $_GET['parent_page'] ?? null;

$pdo = connect_mysql();

if ($parent_page_id != null) {
  $sql = "SELECT * FROM pages WHERE page_id = ?";
  $stmt = $pdo->prepare($sql);
  $stmt->execute([$parent_page_id]);
  $parent_page = $stmt->fetch(PDO::FETCH_ASSOC);

  if (!$parent_page) {
    header("Location: $base_url/");
  }

  $parent_page_title = $parent_page['title'];

}
$stmt = $pdo->prepare("SELECT * FROM pages");
$stmt->execute();
$pages = $stmt->fetchAll(PDO::FETCH_ASSOC);
$pdo = null;


$page_title = "Új oldal";
include __DIR__ . "/modules/header.php";
?>

<div class="row">
  <div class="col-xl-2 col-lg-1 col-sm-0"></div>
  <div class="col-xl-8 col-lg-10 col-sm-12 border border-info rounded bg-info bg-opacity-10 px-4">
    <form action="./handlers/submit-add-page.php" method="POST">
      <h1>
        <?php
        if ($parent_page_id != null) {
          echo "Oldal hozzáadása ehhez: " . htmlspecialchars($parent_page_title);
        } else {
          echo "Oldal hozzáadása a gyökérhez";
        }
        ?>
      </h1>

      <input type="text" name="page_id" value="<?= htmlspecialchars($page_id); ?>" hidden>
      <div class="mb-3 row">
        <input type="text" name="parent_page_id" value="<?= htmlspecialchars($parent_page_id); ?>" hidden>
        <div class="mb-3 row">
          <label for="parent" class="col-12 col-sm-3 col-form-label">Szülő oldal:</label>
          <div class="col-12 col-sm-9">
            <select class="form-select" id="parent" name="parent_page_id" aria-label="Default select example" onchange="
          if (this.value == 'root') {
            window.location.href = './add-page.php';
          } else {
            window.location.href = './add-page.php?parent_page=' + this.value;
          }
          " required>
              <option value="root" <?= $parent_page_id==null ? "selected" : "" ?> >Nincs szülő elem</option>
              <?php
            $pdo = connect_mysql();
            $sql = "SELECT * FROM pages WHERE page_id = ?";

            // Get route of page and display like this: "Parent page > Parent page > Child page"
            foreach ($pages as $page) {
              $route = $page['title'];
              $parent_page_id = $page['parent_page_id'];

              while ($parent_page_id != 0) {
                $stmt = $pdo->prepare($sql);
                $stmt->execute([$parent_page_id]);
                $parent_page = $stmt->fetch(PDO::FETCH_ASSOC);

                $route = $parent_page['title'] . " > " . $route;
                $parent_page_id = $parent_page['parent_page_id'];
              }

              // Display the route
              // Select the current page if it is the parent page
              echo "<option value='" . $page['page_id'] . "' " . ($page['parent_page'] == $_GET['page'] ? "selected" : "") . ">" . $route . "</option>";
            }
            ?>
            </select>
          </div>
        </div>
        <div class="mb-3 row">
          <label for="title" class="col-12 col-sm-3 col-form-label">Cím:</label>
          <div class="col-12 col-sm-9">
            <input type="text" class="form-control" name="title" id="title" placeholder="Cím">
          </div>
        </div>
        <div class="mb-3 row">
          <label for="description" class="col-12 col-sm-3 col-form-label">Leírás:</label>
          <div class="col-12 col-sm-9">
            <input type="text" class="form-control" name="description" id="description" placeholder="Leírás" required>
          </div>
        </div>
        <div class="mb-3 row">
          <label for="img_url" class="col-12 col-sm-3 col-form-label">Kép url:</label>
          <div class="col-12 col-sm-9">
            <input type="url" class="form-control" name="img_url" id="img_url"
              placeholder="https://www.example.com/image.jpg">
          </div>
        </div>
        <div class="mb-3 row">
          <label for="banner_img_url" class="col-12 col-sm-3 col-form-label">Banner kép url:</label>
          <div class="col-12 col-sm-9">
            <input type="url" class="form-control" name="banner_img_url" id="banner_img_url"
              placeholder="https://www.example.com/banner-image.jpg">
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
<?php
include __DIR__ . "/modules/footer.php";
?>