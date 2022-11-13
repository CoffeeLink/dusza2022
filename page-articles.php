<?php
include __DIR__ . "/lib/utils.php";
$base_url = (require __DIR__ . "/config/config.php")['base_url'];

session_start(); // Start the session.

$token = $_SESSION['jwt_token'] ?? null;

if(!checkPermission($token, 'MODERATOR')) {
    header("Location: $base_url/something-went-wrong.php?code=403");

    return;
}

$pdo = connect_mysql();
$sql = "SELECT * FROM articles";
$page_id = 0;
if (isset($_GET['page'])) {
    $page_id = (int) $_GET['page'];
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
include __DIR__ . "/modules/admin-header.php";
?>

<!-- Tartalom -->
<div class="container-fluid">
    <div class="row elsosor">
        <div class="col-6">
            <h3>Bejegyzések kezelése</h3>
        </div>
        <?php if ($page_id != 0) { ?>
        <div class="col-6">
            <a class="btn btn-secondary hozzaadas" href="./add-article.php?page=<?= htmlspecialchars($page_id) ?>">Új
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
                <th>Publikálás</th>
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
                <td class="id">
                    <?= htmlspecialchars($article['article_id']) ?>
                </td>
                <td class="id">
                    <?= htmlspecialchars($article['page_id']) ?>
                </td>
                <td>
                    <?= htmlspecialchars($article['title']) ?>
                </td>
                <td>
                    <?php
                if ($article['is_visible'] == 1) {
                    echo "Publikus";
                } else {
                    echo "Rejtett";
                }
                    ?>
                </td>
                <td>
                    <?= htmlspecialchars($article['created_at']) ?>
                </td>
                <td>
                    <?= htmlspecialchars($editedBy) ?> ~ <?= htmlspecialchars($article['edited_at']) ?>
                </td>
                <td>
                    <?= $createdBy ?>
                </td>
                <td>
                    <a href="./view-article.php?article=<?= htmlspecialchars($article['article_id']) ?>" target="_blank"
                        class="btn btn-success">
                        <i class="fa-solid fa-eye"></i></a><a class="btn btn-primary kezeles"
                        href="./edit-article.php?article=<?= htmlspecialchars($article['article_id']) ?>">
                        <i class="fa-solid fa-edit"></i></a><a class="btn btn-danger kezeles"
                        href="./handlers/submit-delete-article.php?article=<?= htmlspecialchars($article['article_id']) ?>">
                        <i class="fa-solid fa-ban"></i>
                    </a>
                </td>
                <td>
                    <?php if ($article['is_visible'] == 1) { ?>
                    <a class="btn btn-danger kezeles"
                        href="./handlers/submit-set-article-visibility.php?article=<?= htmlspecialchars($article['article_id']) ?>&visibility=0">
                        <i class="fa-solid fa-ban"></i>
                    </a>
                    <?php } else { ?>
                    <a class="btn btn-success kezeles"
                        href="./handlers/submit-set-article-visibility.php?article=<?= htmlspecialchars($article['article_id']) ?>&visibility=1">
                        <i class="fa-solid fa-check"></i>
                    </a>
                    <?php } ?>
            </tr>
            <?php } ?>

        </tbody>
    </table>
    <!-- Lapozás a következő oldalra -->
    <div class="lapoz">
        <span class="px-3">Megjelenítve: <b>1-<?= htmlspecialchars($posts_number) ?></b>/<?=
                htmlspecialchars($posts_number) ?></span>
        <button class="btn btn-secondary">
            <i class="fa-solid fa-arrow-left"></i>
        </button>
        <button class="btn btn-secondary">
            <i class="fa-solid fa-arrow-right"></i>
        </button>
    </div>

    <?php
    include __DIR__ . "/modules/admin-footer.php";
    ?>