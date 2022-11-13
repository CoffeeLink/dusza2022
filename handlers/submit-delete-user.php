<?php

require __DIR__ . "/../lib/utils.php";
$config = require(__DIR__ . '/../config/config.php');
$base_url = (require __DIR__ . "/../config/config.php")['base_url'];

$token = $_SESSION['jwt_token'] ?? null;
if (!checkPermission($token, 'WEBMASTER')) {
    header("Location: $base_url/something-went-wrong.php?errorTitle=You%20do%20not%20have%20permission%20to%20edit%20users.&errorDescription=You%20do%20not%20have%20permission%20to%20edit%20users.&errorCode=403");
    return;
}
$user_id = $_GET['user_id'];

$pdo = connect_mysql();
$sql = "DELETE FROM users WHERE user_id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$user_id]);

header("Location: $base_url/page-users.php");