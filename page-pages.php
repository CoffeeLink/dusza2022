<?php
include __DIR__."./lib/connection.php";
$pdo = connect_mysql();
$sql = "SELECT * FROM pages ORDER BY created_at DESC";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$pages = [];
$posts_number = 0;
while ($page = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $pages[] = $page;
    $posts_number++;
}
$aktiv_menu = "oldalak";
include __DIR__."./admin_header.php";
?>

<!-- Tartalom -->
<div class="container-fluid">
    <div class="row elsosor">
        <div class="col-6">
            <h3>Oldalak kezelése</h3>
        </div>
        <div class="col-6">
            <a class="btn btn-secondary hozzaadas" href="./add-page.php">Új hozzáadása</a>
        </div>
    </div>
    <!-- Adatokat megjelenítő táblázat -->
    <table class="table table-responsive">
        <!-- Táblázat adatai -->
        <thead>
            <tr>
                <th class="id">ID</th>
                <th>Oldal címe</th>
                <th>Állapot</th>
                <th>Létrehozás dátuma</th>
                <th>Legutóbbi módosítás</th>
                <th>Szerző</th>
                <th>Kezelés</th>
            </tr>
        </thead>
        <!-- Tartalmak megjelenítése -->
        <tbody>
            <?php foreach ($pages as $page) {
                $editedUser = get_user_by_id($page['edited_by_user_id']);
                $editedUserName = $editedUser['last_name'] . ' ' . $editedUser['first_name'];
                $createdUser = get_user_by_id($page['edited_by_user_id']);
                $createdUserName = $createdUser['last_name'] . ' ' . $createdUser['first_name'];
            ?>

            <tr>
                <td class="id"><?= $page['page_id'] ?></td>
                <td><?= $page['title'] ?></td>
                <td><?php
                        if ($page['is_visible'] == 1) {
                            echo "Publikus";
                        } else {
                            echo "Piszkozat";
                        }
                        ?></td>
                <td><?= $page['created_at'] ?></td>
                <td><?= $createdUserName ?> ~
                    <?= $page['edited_at'] ?></td>
                <td><?= $editedUserName ?></td>
                <td>
                    <a href="./view-page.php?page=<?= $page['page_id'] ?>" target="_blank" class="btn btn-success">
                        <i class="fa-solid fa-eye"></i>
                    </a>
                    <a class="btn btn-warning kezeles" href="./page-articles.php?page=<?= $page['page_id'] ?>">
                        <i class="fa-solid fa-rectangle-list"></i>
                    </a>
                    <a class="btn btn-primary kezeles" href="./edit-page.php?page=<?= $page['page_id'] ?>">
                        <i class="fa-solid fa-edit"></i></a><a class="btn btn-danger kezeles"
                        href="./handlers/submit-delete-page.php?page=<?= $page['page_id'] ?>">
                        <i class="fa-solid fa-ban"></i>
                    </a>
                </td>
            </tr>

            <?php } ?>

        </tbody>
    </table>
    <!-- Lapozás a következő oldalra -->
    <div class="lapoz">
        <span class="px-3">Megjelenítve: <b>1-<?= $posts_number ?></b>/<?= $posts_number ?></span>
        <button class="btn btn-secondary">
            <i class="fa-solid fa-arrow-left"></i>
        </button>
        <button class="btn btn-secondary">
            <i class="fa-solid fa-arrow-right"></i>
        </button>
    </div>
</div>
<?php
include __DIR__."/admin_footer.php";
?>