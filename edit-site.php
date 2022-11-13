<?php
include __DIR__ . "/lib/utils.php";
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
$aktiv_menu = "portal_kezeles";
include __DIR__ . "/admin-header.php";
?>

<!-- Tartalom -->
<div class="container-fluid">
    <div class="row elsosor">
        <div class="col-12">
            <h3>Webhely beállítások módosítása</h3>
        </div>
    </div>
    <form action="">
        <div class="container">
            <div class="mb-3 row">
                <label for="user_name" class="col-sm-3 col-form-label">Oldal neve:</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="site_name" name="site_name" placeholder="Blog" required>
                </div>
            </div>
            <div class="mb-3 row">
                <label for="inputPassword" class="col-sm-3 col-form-label">Bemutatkozó szöveg:</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="description" name="description"
                        placeholder="Ez egy blog oldal." required>
                </div>
            </div>
            <div class="mb-3 row">
                <label for="email" class="col-sm-3 col-form-label">Admin email-cím:</label>
                <div class="col-sm-9">
                    <input type="email" class="form-control" id="email" name="email" placeholder="email@example.com"
                        required>
                </div>
            </div>
            <div class="mb-3 row">
                <label for="profile_picture" class="col-sm-3 col-form-label">Weboldal ikonja:</label>
                <div class="col-sm-9">
                    <input type="file" class="form-control" id="profile_picture" name="profile_picture"
                        accept="image/png, image/jpeg, image/jpg, image/gif">
                </div>
            </div>
            <button type="submit" class="btn btn-success hozzaadas" id="create_user">Mentés</button>
        </div>
    </form>
</div>
<?php
include __DIR__ . "/admin-footer.php";
?>