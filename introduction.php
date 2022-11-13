<?php
require __DIR__ . "/lib/utils.php";
require_once __DIR__ . '/vendor/autoload.php';
use Michelf\Markdown;

$settings = json_decode(file_get_contents(__DIR__ . "/settings/settings.json"), true);

$page_title = "Bemutaatkozás";
include __DIR__ . "/modules/header.php";
?>

<div class="row">
    <div class="col-xl-2 col-lg-1 col-md-0"></div>

    <div class="col-xl-8 col-lg-10 col-md-12">
        <h1>Bemutatkozás</h1>
        <p>
            <?= Markdown::defaultTransform($settings['description']) ?>
        </p>
    </div>

    <div class="col-xl-2 col-lg-1 col-md-0"></div>
</div>

<?php
include __DIR__ . "/modules/footer.php";
?>