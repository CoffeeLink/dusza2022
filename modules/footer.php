<?php
// Start the session.
if (!isset($_SESSION)) {
    session_start();
}

$settings = json_decode(file_get_contents(__DIR__ . "/../settings/settings.json"), true);
?>
</div>
<!-- Lábléc -->
<div class="kulso">
    <div class="container">
        <footer class="d-flex flex-wrap justify-content-between align-items-center py-3 my-4 mb-0">
            <p class="col-md-4 mb-0">
                <a href="./" class="nav-link"><span class="fs-4"><?= $settings['name'] ?></a>
            </p>

            <ul class="nav col-md-4 justify-content-end">
                <li class="nav-item">
                    <a href="./" class="nav-link px-3">Főoldal</a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link px-3">Oldal1</a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link px-3">Oldal2</a>
                </li>
                <li class="nav-item">
                    <?php if (isset($_SESSION['jwt_token'])): ?>
                    <a href="./handlers/logout.php" class="nav-link px-3">Kijelentkezés</a>
                    <?php else: ?>
                    <a href="./login.php" class="nav-link px-3">Bejelentkezés</a>
                    <?php endif; ?>
                </li>
            </ul>
        </footer>
    </div>
</div>
</body>

</html>