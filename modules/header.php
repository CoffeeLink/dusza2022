<?php
// Start the session.
if (!isset($_SESSION)) {
  session_start();
}

$token = $_SESSION['jwt_token'] ?? null;

$settings = json_decode(file_get_contents(__DIR__ . "/../settings/settings.json"), true);
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

    <!-- Saját JavaScript behívása -->
    <script defer src="./js/app.js"></script>

    <!-- Saját CSS behívása -->
    <link rel="stylesheet" href="./css/page.css" />
    <title>
        <?= $page_title ?>
    </title>

    <?php include __DIR__ . "/global-head.php" ?>
</head>

<body>
    <!-- Weboldalt körbefoglaló div -->
    <div class="container">
        <!-- Navigációs sor behívása -->
        <header class="d-flex flex-wrap justify-content-center py-3 mb-4 border-bottom">
            <!-- Weboldal főcímének megjelenítése -->
            <a href="./" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-dark text-decoration-none">
                <span class="fs-4">
                    <?= $settings['name'] ?>
                </span>
            </a>

            <!-- Navigációs sor hivatkozásai -->
            <ul class="nav nav-pills">
                <li class="nav-item">
                    <a href="./" class="nav-link">Főoldal</a>
                </li>
                <?php
                if (checkPermission($token, 'MODERATOR')) {
                echo '<li class="nav-item"><a href="./dashboard.php" class="nav-link">Vezérlőpult</a></li>';
                }
                ?>
                <li class="nav-item">
                    <?php if (isset($_SESSION['jwt_token'])): ?>
                <a href="./handlers/logout.php" class="nav-link">Kijelentkezés</a>
                <?php else: ?>
                <a href="./login.php" class="nav-link">Bejelentkezés</a>
                <?php endif; ?>
                </li>
                <li class="nav-item search-item">
                    <input type="search" class="form-control" placeholder="Keresés" aria-label="Search" />
                </li>

                <!-- Keresés -->
                <li class="nav-item">
                    <button type="submit" class="btn-primary btn kereses">
                        <i class="fa fa-search"></i>
                    </button>
                </li>
            </ul>
        </header>