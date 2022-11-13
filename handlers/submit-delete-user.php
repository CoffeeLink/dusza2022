<?php

require __DIR__ . "/../lib/utils.php";
$config = require(__DIR__ . '/../config/config.php');
$base_url = (require __DIR__ . "/../config/config.php")['base_url'];

session_start();

$token = $_SESSION['jwt_token'] ?? null;
if (!checkPermission($token, 'WEBMASTER')) {
    header("Location: $base_url/something-went-wrong.php?code=403");
    return;
}
$user_id = $_GET['user'];

$pdo = connect_mysql();
$sql = "DELETE FROM users WHERE user_id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$user_id]);

header("Location: $base_url/page-users.php");