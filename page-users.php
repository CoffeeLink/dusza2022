<?php
include "./lib/connection.php";
$pdo = connect_mysql();
$sql = "SELECT * FROM users ORDER BY user_name ASC";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$users = [];
$posts_number = 0;
while ($user = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $users[] = $user;
    $posts_number++;
}
$aktiv_menu = "felhasznalok";
include "./admin_header.php";
?>

<!-- Tartalom -->
<div class="container-fluid">
    <div class="row elsosor">
        <div class="col-6">
            <h3>Felhasználók kezelése</h3>
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
                <th>Felhasználónév</th>
                <th>Email cím</th>
                <th>Teljes név</th>
                <th>Jogosultsági szint</th>
                <th>Registráció ideje</th>
                <th>Kezelés</th>
            </tr>
        </thead>
        <!-- Tartalmak megjelenítése -->
        <tbody>
            <?php foreach ($users as $user) {
            ?>

            <tr>
                <td class="id"><?= $user['user_id'] ?></td>
                <td><?= $user['user_name'] ?></td>
                <td><?= $user['email'] ?></td>
                <td><?= $user['last_name'] . ' ' . $user['first_name'] ?></td>
                <td><?= $user['permission'] ?></td>
                <td><?= $user['registered_at'] ?></td>
                <td>
                    <a class="btn btn-primary kezeles" href="./edit-page.php?page=<?= $user['page_id'] ?>">
                        <i class="fa-solid fa-edit"></i></a><a class="btn btn-danger kezeles"
                        href="./handlers/submit-delete-page.php?page=<?= $user['page_id'] ?>">
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
include "./admin_footer.php";
?>