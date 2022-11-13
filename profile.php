<?php
include __DIR__ . "/lib/utils.php";
$base_url = (require __DIR__ . "/config/config.php")['base_url'];
session_start();

$token = $_SESSION['jwt_token'] ?? null;

if(!checkPermission($token, 'MODERATOR')) {
    header("Location: $base_url/something-went-wrong.php?code=403");

    return;
}

$pdo = connect_mysql();
$sql = "SELECT * FROM users WHERE user_id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([getUserId($token)]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);
$pdo = null;

$aktiv_menu = "profilom";
include __DIR__ . "/modules/admin-header.php";
?>

<!-- Tartalom -->
<div class="container-fluid">
    <div class="row elsosor">
        <div class="col-6">
            <h3>Profil szerkesztése</h3>
        </div>
        <div class="col-6">
            <a class="btn btn-secondary hozzaadas" href="./page-users.php">Vissza</a>
        </div>
    </div>
    <form action="./handlers/submit-edit-user.php" method="POST">
        <input type="text" name="user_id" id="user_id" value="<?= $user["user_id"]?>" hidden>
        <div class="container">
            <div class="mb-3 row">
                <label for="username" class="col-sm-3 col-form-label">Felhasználónév:</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="username" name="username" placeholder="john_doe"
                        value="<?php echo htmlspecialchars($user["user_name"]) ?>" required>
                </div>
            </div>
            <div class="mb-3 row">
                <label for="inputPassword" class="col-sm-3 col-form-label">Új jelszó:</label>
                <div class="col-sm-9">
                    <input type="password" class="form-control" id="inputPassword" name="password"
                        placeholder="••••••••">
                </div>
            </div>
            <div class="mb-3 row">
                <label for="email" class="col-sm-3 col-form-label">Email-cím:</label>
                <div class="col-sm-9">
                    <input type="email" class="form-control" id="email" name="email" placeholder="email@example.com"
                        value="<?php echo htmlspecialchars($user["email"]) ?>" required>
                </div>
            </div>
            <div class="mb-3 row">
                <label for="lastname" class="col-sm-3 col-form-label">Vezetéknév:</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="lastname" name="last_name" placeholder="Doe" value="<?php echo htmlspecialchars($user["last_name"]) ?>" required>
                </div>
            </div>
            <div class="mb-3 row">
                <label for="first_name" class="col-sm-3 col-form-label">Keresztnév:</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="first_name" name="first_name" placeholder="John"
                        value="<?php echo htmlspecialchars($user["first_name"]) ?>" required>
                </div>
            </div>
            <!-- <div class="mb-3 row">
                <label for="profile_picture" class="col-sm-3 col-form-label">Profilkép</label>
                <div class="col-sm-9">
                    <input type="file" class="form-control" id="profile_picture" name="profile_picture"
                        accept="image/png, image/jpeg, image/jpg, image/gif">
                </div>
            </div> -->
            <button type="submit" class="btn btn-success hozzaadas" id="create_user">Mentés</button>
        </div>
    </form>
</div>
<?php
include __DIR__ . "/modules/admin-footer.php";
?>