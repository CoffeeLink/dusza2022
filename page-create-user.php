<?php
include "./lib/connection.php";
$aktiv_menu = "felhasznaloAdd";
include "./admin_header.php";
?>

<!-- Tartalom -->
<div class="container-fluid">
    <div class="row elsosor">
        <div class="col-6">
            <h3>Felhasználó létrehozása</h3>
        </div>
        <div class="col-6">
            <a class="btn btn-secondary hozzaadas" href="./page-users.php">Vissza</a>
        </div>
    </div>
    <form action="./handlers/register.php" method="POST">
        <div class="container">
            <div class="mb-3 row">
                <label for="username" class="col-sm-3 col-form-label">Felhasználónév:</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="user_name" name="username" placeholder="john_doe"
                        required>
                </div>
            </div>
            <div class="mb-3 row">
                <label for="inputPassword" class="col-sm-3 col-form-label">Jelszó:</label>
                <div class="col-sm-9">
                    <input type="password" class="form-control" id="inputPassword" name="password"
                        placeholder="••••••••" required>
                </div>
            </div>
            <div class="mb-3 row">
                <label for="email" class="col-sm-3 col-form-label">Email-cím:</label>
                <div class="col-sm-9">
                    <input type="email" class="form-control" id="email" name="email" placeholder="email@example.com"
                        required>
                </div>
            </div>
            <div class="mb-3 row">
                <label for="lastname" class="col-sm-3 col-form-label">Vezetéknév:</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="lastname" name="last_name" placeholder="Doe" required>
                </div>
            </div>
            <div class="mb-3 row">
                <label for="first_name" class="col-sm-3 col-form-label">Keresztnév:</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="first_name" name="first_name" placeholder="John"
                        required>
                </div>
            </div>
            <div class="mb-3 row">
                <label for="birth_date" class="col-sm-3 col-form-label">Születési dátum:</label>
                <div class="col-sm-9">
                    <input type="date" class="form-control" id="birth_date" name="birth_date" max="2022-01-01">
                </div>
            </div>
            <div class="mb-3 row">
                <label for="permission" class="col-sm-3 col-form-label">Jogosultsági szint:</label>
                <div class="col-sm-9">
                    <select class="form-select" id="permission" name="permission">
                        <option value="EDITOR" selected>Szerkesztő</option>
                        <option value="MODERATOR">Moderátor</option>
                        <option value="WEBMASTER">Webmester</option>
                    </select>
                </div>
            </div>
            <div class="mb-3 row">
                <label for="profile_picture" class="col-sm-3 col-form-label">Profilkép</label>
                <div class="col-sm-9">
                    <input type="file" class="form-control" id="profile_picture" name="profile_picture"
                        accept="image/png, image/jpeg, image/jpg, image/gif">
                </div>
            </div>
            <button type="submit" class="btn btn-success hozzaadas" id="create_user">Létrehozás</button>
        </div>
    </form>
</div>
<?php
include "./admin_footer.php";
?>