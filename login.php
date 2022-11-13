<?php
require __DIR__ . "/lib/utils.php";
require_once __DIR__ . '/vendor/autoload.php';
$base_url = (require __DIR__ . "/config/config.php")['base_url'];
$page_title = "Bejeletkezés";
session_start();
include __DIR__ . "/header.php";
?>

<body>
    <div class="row">
        <div class="col-xl-3 col-lg-2 col-sm-0"></div>
        <div class="col-xl-6 col-lg-8 col-sm-12 border border-info rounded bg-info bg-opacity-10 px-4">
            <h1 class="text-center">Bejelentkezés</h1>
            <form action="./handlers/authorize.php" method="POST">
                <div class="mb-3 row">
                    <label for="username" class="col-12 col-sm-3 col-form-label">Felhasználónév:</label>
                    <div class="col-12 col-sm-9">
                        <input type="text" class="form-control" name="username" id="username" placeholder="john_doe"
                            required>
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="email" class="col-12 col-sm-3 col-form-label">Jelszó:</label>
                    <div class="col-12 col-sm-9">
                        <input type="password" class="form-control" name="password" placeholder="••••••••" required>
                    </div>

                    <input class="btn btn-primary teljes my-4 py-2" type="submit" value="Bejelentkezés" id="#frmLogin">

            </form>

        </div>
        <div class="col-xl-3 col-lg-2 col-sm-0"></div>
    </div>
    </div>

    <?php
    $error = $_GET['error'] ?? null;
    if ($error == 1) {
        echo "<p>Invalid username or password</p>";
    }
    ?>
</body>

</html>