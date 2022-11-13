<?php
require __DIR__ . "/lib/utils.php";
$base_url = (require __DIR__ . "/config/config.php")['base_url'];

$pdo = connect_mysql();

// Get all root pages
$sql = "SELECT * FROM pages WHERE parent_page_id IS NULL";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$pages = $stmt->fetchAll(PDO::FETCH_ASSOC);
$page_title = "Főoldal";
include __DIR__ . "/modules/header.php";
?>

<!DOCTYPE html>
<html lang="en">

<!-- Általános információk -->
<h1>Weboldal neve</h1>
<h3 class="description pb-3">Bemutatkozó szöveg</h3>

<!-- Oldalak kilistázása -->
<h4>Oldalaink:</h4>
<?php
foreach ($pages as $page) {
  $page_id = $page['page_id'];
  $title = $page['title'];
  $description = $page['description'];
  $time = $page['created_at'];
?>
<div class="row">
    <a class="text-decoration-none text-dark hover-white mb-2"
        href="./view-page.php?page=<?php echo htmlspecialchars($page_id) ?>">
        <h3 class=" pt-3"><?= htmlspecialchars($title) ?></h3>
        <div class="row">
            <div class="col-10">
                <p class="fs-5"><?= htmlspecialchars($description) ?></p>
            </div>
            <div class="col-2">
                <p class="jobbra-szoveg"><i><?= htmlspecialchars($time) ?></i></p>
            </div>
        </div>
    </a>
    <hr>
</div>


<?php
}
?>

<!-- Oldal hozzáadása gomb -->
<a class="btn btn-success" href="./add-page.php">Oldal hozzáadása</a>

</a>
<?php
include __DIR__ . "/modules/footer.php";
?>