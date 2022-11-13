<?php
require_once __DIR__ . "/lib/utils.php";
$base_url = (require __DIR__ . "/config/config.php")['base_url'];

if (!isset($_SESSION)) {
    session_start();
}

$token = $_SESSION['jwt_token'] ?? null;

$user_id = getUserId($token);

$pdo = connect_mysql();
$sql = "SELECT * FROM users WHERE user_id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$user_id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="hu">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <!-- Bootstrap behívása -->
    <link rel="stylesheet" href="./css/bootstrap/css/bootstrap.min.css" />
    <script src="./css/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Font Awesome behívása -->
    <script src="https://kit.fontawesome.com/df92ea1e57.js" crossorigin="anonymous"></script>

    <!-- Saját CSS behívása -->
    <link rel="stylesheet" href="./css/admin.css" />
    <title>Vezérlőpult</title>
</head>

<body>
    <header class="d-flex flex-wrap justify-content-center py-1 border-bottom">
        <!-- Weboldal főcímének megjelenítése -->
        <div class="d-flex align-items-center mb-md-0 me-md-auto">
            <span class="fs-4"><a href="#" class="text-dark text-decoration-none"><i
                        class="fa-solid fa-house px-3"></i></a><a href="#"
                    class="text-dark text-decoration-none">Vezérlőpult</a></span>
        </div>

        <!-- Navigációs sor hivatkozásai -->
        <div class="dropdown d-flex">
            <a href="#" class="d-flex align-items-center link-dark text-decoration-none" data-bs-toggle="dropdown"
                aria-expanded="false">
                <strong class="px-2">
                    <?php
                    echo htmlspecialchars($user['last_name']) . ' ' . htmlspecialchars($user['first_name']) . ' (' . htmlspecialchars($user['user_name']) . ')';
                    ?>
                </strong>
                <img src="./img/default_profile_picture.png" alt="" width="32" height="32"
                    class="rounded-circle me-2 profile_pic" />
            </a>
            <ul class="dropdown-menu text-small shadow">
                <li>
                    <a class="dropdown-item" href="#">Saját oldalak megtekintése</a>
                    <a class="dropdown-item" href="#">Saját profil szerkesztése</a>
                </li>
                <li>
                    <hr class="dropdown-divider" />
                </li>
                <li><a class="dropdown-item" href="#">Kijelentkezés</a></li>
            </ul>
        </div>
    </header>

    <!-- A navigációs soron kívüli tartalmi rész -->
    <div class="befoglalo">
        <!-- Oldalsó sáv -->
        <div class="d-flex flex-column flex-shrink-0 p-3 oldalsav_div" style="width: 280px">
            <a href="/" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto link-dark text-decoration-none">
                <span class="fs-4">Portál kezelése</span>
            </a>
            <hr />
            <ul class="nav nav-pills flex-column mb-auto oldalsav">
                <li class="nav-item">
                    <a href="./dashboard.php" class="nav-link link-dark" aria-current="page" id="vezerlopult">
                        <i class="fa-solid fa-gauge-high icon"></i> Vezérlőpult
                    </a>
                </li>
                <hr />
                <li>
                    <a href="./profile.php" class="nav-link link-dark" id="profilom">
                        <i class="fa-solid fa-user icon"></i>
                        Profilom
                    </a>
                </li>
                <hr />
                <li>
                    <a href="./edit-site.php" class="nav-link link-dark" id="portal_kezeles">
                        <i class="fa-solid fa-gears icon"></i>
                        Portál kezelése
                    </a>
                </li>
                <li>
                    <a href="./page-users.php" class="nav-link link-dark" id="felhasznalok">
                        <i class="fa-solid fa-users icon"></i>
                        Felhasználók
                    </a>
                </li>
                <li>
                    <a href="./page-create-user.php" class="nav-link link-dark" id="felhasznaloAdd">
                        <i class="fa-solid fa-user-plus"></i>
                        Felhasználó hozzáadása
                    </a>
                </li>
                <hr />
                <li>
                    <a href="./page-pages.php" class="nav-link link-dark" id="oldalak">
                        <i class="fa-solid fa-file-lines icon"></i>
                        Oldalak
                    </a>
                </li>
                <li>
                    <a href="./page-articles.php" class="nav-link link-dark" id="bejegyzesek">
                        <i class="fa-solid fa-pen icon"></i>
                        Bejegyzések
                    </a>
                </li>

                <hr />
                <li>
                    <a href="./" class="nav-link link-dark">
                        <i class="fa-solid fa-house icon"></i>
                        Vissza az oldalra
                    </a>
                </li>
                <li>
                    <a href="./handlers/logout.php" class="nav-link link-dark">
                        <i class="fa-solid fa-right-from-bracket icon"></i>
                        Kijelentkezés
                    </a>
                </li>
            </ul>
        </div>