<?php
include __DIR__ . "/lib/utils.php";
include __DIR__ . "/vendor/autoload.php";

$settings = json_decode(file_get_contents(__DIR__ . "/settings/settings.json"), true);

$name = $settings['name'];
$description = $settings['description'];
$email = $settings['email'];
//$icon = $settings['icon'];

$aktiv_menu = "portal_kezeles";
include __DIR__ . "/modules/admin-header.php";
?>

<!-- Tartalom -->
<script defer src="./js/edit-site.js"></script>
<div class="container-fluid">
    <div class="row elsosor">
        <div class="col-12">
            <h3>Webhely beállítások módosítása</h3>
        </div>
    </div>
    <form id="edit-site-form">
        <div class="container">
            <div class="mb-3 row">
                <label for="site_name" class="col-sm-3 col-form-label">Oldal neve:</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="site_name" name="site_name" placeholder="Blog" value="<?= htmlspecialchars($name); ?>" required>
                </div>
            </div>
            <div class="mb-3 row">
                <label for="inputPassword" class="col-sm-3 col-form-label">Bemutatkozó szöveg:</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="description" name="description"
                        placeholder="Ez egy blog oldal." value="<?= htmlspecialchars($description); ?>" required>
                </div>
            </div>
            <div class="mb-3 row">
                <label for="email" class="col-sm-3 col-form-label">Admin email-cím:</label>
                <div class="col-sm-9">
                    <input type="email" class="form-control" id="email" name="email" placeholder="email@example.com" value="<?= htmlspecialchars($email); ?>" required>
                </div>
            </div>
            <div class="mb-3 row">
                <label for="icon" class="col-sm-3 col-form-label">Weboldal ikonja:</label>
                <div class="col-sm-9">
                    <input type="file" class="form-control" id="icon" name="icon"
                        accept="image/png, image/jpeg, image/jpg, image/gif">
                </div>
            </div>
            <button type="submit" class="btn btn-success hozzaadas" id="create_user">Mentés</button>
        </div>
    </form>
</div>
<?php
include __DIR__ . "/modules/admin-footer.php";
?>