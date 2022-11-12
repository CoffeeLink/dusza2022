<?php
include __DIR__."/lib/connection.php";
$pdo = connect_mysql();
$sql = "SELECT * FROM articles";
$page_id = 0;
if (isset($_GET['page'])) {
    $page_id = (int)$_GET['page'];
    $sql .= " WHERE page_id = " . $page_id;
}
$stmt = $pdo->prepare($sql);
$stmt->execute();
$articles = [];
$posts_number = 0;
while ($article = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $articles[] = $article;
    $posts_number++;
}
$aktiv_menu = "bejegyzesek";
include __DIR__."/admin_header.php";
?>

<!-- Tartalom -->
<div class="container-fluid">
    <div class="row elsosor">
        <div class="col-6">
            <h3>Bejegyzések kezelése</h3>
        </div>
        <?php if ($page_id != 0) { ?>
        <div class="col-6">
            <a class="btn btn-secondary hozzaadas" href="./add-article.php?page=<?= $page_id ?>">Új
                hozzáadása</a>
        </div>
        <?php } ?>

    </div>
    <!-- Adatokat megjelenítő táblázat -->
    <table class="table table-responsive">
        <!-- Táblázat adatai -->
        <thead>
            <tr>
                <th class="id">ID</th>
                <th class="id">Oldal ID</th>
                <th>Bejegyzés címe</th>
                <th>Állapot</th>
                <th>Létrehozás dátuma</th>
                <th>Legutóbbi módosítás</th>
                <th>Szerző</th>
                <th>Kezelés</th>
            </tr>
        </thead>
        <!-- Tartalmak megjelenítése -->
        <tbody>
            <?php foreach ($articles as $article) {
                $user = getUserById($article['edited_by_user_id']);
                $editedBy = $user['last_name'] . ' ' . $user['first_name'];
                $user = getUserById($article['author_user_id']);
                $createdBy = $user['last_name'] . ' ' . $user['first_name'];
            ?>

            <tr>
                <td class="id"><?= $article['article_id'] ?></td>
                <td class="id"><?= $article['page_id'] ?></td>
                <td><?= $article['title'] ?></td>
                <td><?php
                        if ($article['is_visible'] == 1) {
                            echo "Publikus";
                        } else {
                            echo "Piszkozat";
                        }
                        ?></td>
                <td><?= $article['created_at'] ?></td>
                <td><?= $editedBy ?> ~ <?= $article['edited_at'] ?></td>
                <td><?= $createdBy ?></td>
                <td>
                    <a href="./view-article.php?article=<?= $article['article_id'] ?>" target="_blank"
                        class="btn btn-success">
                        <i class="fa-solid fa-eye"></i></a><a class="btn btn-primary kezeles"
                        href="./edit-article.php?article=<?= $article['article_id'] ?>">
                        <i class="fa-solid fa-edit"></i></a><a class="btn btn-danger kezeles"
                        href="./handlers/submit-delete-article.php?article=<?= $article['article_id'] ?>">
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

    <?php
    include __DIR__."./admin_footer.php";
    ?>