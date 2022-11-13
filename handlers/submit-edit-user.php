<?php
require __DIR__ . "/../lib/utils.php";
$config = require(__DIR__ . '/../config/config.php');
$base_url = (require __DIR__ . "/../config/config.php")['base_url'];

session_start();

$token = $_SESSION['jwt_token'] ?? null;

if(!checkPermission($token, 'WEBMASTER')) {
    header("Location: $base_url/something-went-wrong.php?code=403");
    return;
}
$pdo = connect_mysql();

$user_id = $_POST['user_id'];
$username = $_POST['username'];
$password = hash("sha256", $_POST['password']) ?? null;
$email = $_POST['email'];
$firs_name = $_POST['first_name'];
$last_name = $_POST['last_name'];
$permission = $_POST['permission'];

if ($password == null) {
    $sql = "UPDATE users SET username = ?, email = ?, first_name = ?, last_name = ?, permission = ? WHERE user_id = ?";
    $stmt = $pdo->prepare($sql);
    $e = $stmt->execute([$username, $email, $firs_name, $last_name, $permission, $user_id]);
} else {
    $sql = "UPDATE users SET username = ?, password = ?, email = ?, first_name = ?, last_name = ?, permission = ? WHERE user_id = ?";
    $stmt = $pdo->prepare($sql);
    $e = $stmt->execute([$username, $password, $email, $firs_name, $last_name, $permission, $user_id]);
}

$pdo = null;

if ($e) {
    header("Location: $base_url/page-users.php");
} else {
    header("Location: $base_url/something-went-wrong.php?code=500");
}

