<?php

$errorTitle = $_GET['errorTitle'] ?? 'Hiba történt';
$errorDescription = $_GET['errorDescription'] ?? 'Hiba történt';
$errorCode = $_GET['errorCode'] ?? '500';
include __DIR__ . "/header.php";
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