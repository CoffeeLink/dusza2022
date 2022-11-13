<?php

$errorMessages = require __DIR__ . "/config/error-messages.php";

//TODO: 1. legyen értelmük :D
$errorTitle = $_GET['errorTitle'] ?? null;
$errorDescription = $_GET['errorDescription'] ?? null;
$errorCode = $_GET['code'] ?? 'ISMERETLEN';
$page_title = $errorTitle;

if ($errorCode == 'ISMERETLEN') {
  $errorTitle = 'Hiba';
  $errorDescription = 'Ismeretlen hiba történt';
}

if ($errorTitle == null) {
  $errorTitle = $errorMessages[$errorCode]['title'];
}

if ($errorDescription == null) {
  $errorDescription = $errorMessages[$errorCode]['description'];
}

include __DIR__ . "/modules/header.php";
?>
<div class="row py-5 error_kulso">
    <div class="col-sm-12 col-md-6 px-2">
        <img class="error img-fluid img-thumbnail" src="./img/error.png" alt="Valami hiba történt">
    </div>
    <div class="col-sm-12 col-md-6 px-5 py-3">
        <h2><?= $errorTitle ?></h2>

        <div class="description py-2"><?= $errorDescription ?></div>
        <div class="code py-2">Hibakód: <b><?= $errorCode ?></b></div>
        <div class="py-3">A hiba okozta kellemetlenségért elnézést kérünk.</div>
        <a href="./" class="btn btn-primary my-4 jobbra">Vissza a főoldalra</a>
    </div>
</div>


</div>
</body>

</html>