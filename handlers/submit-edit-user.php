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
$permission = $_POST['permission'] ?? null;

if ($permission == null || $permission == "") {
    $stmt = $pdo->prepare("SELECT * FROM users WHERE user_id = ?");
    $stmt->execute([$user_id]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    $permission = $user['permission'];
}

if ($password == null || $password == hash("sha256", "")) {
    $stmt = $pdo->prepare("SELECT * FROM users WHERE user_id = ?");
    $stmt->execute([$user_id]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    $password = $user['password'];
}



if ($password == null) {
    $sql = "UPDATE users SET user_name = ?, email = ?, first_name = ?, last_name = ?, permission = ? WHERE user_id = ?";
    $stmt = $pdo->prepare($sql);
    if($stmt->execute([$username, $email, $firs_name, $last_name, $permission, $user_id])){
        header("Location: $base_url/page-users.php");
    } else {
        header("Location: $base_url/something-went-wrong.php?code=500");
    }
} else {
    $sql = "UPDATE users SET user_name = ?, password = ?, email = ?, first_name = ?, last_name = ?, permission = ? WHERE user_id = ?";
    $stmt = $pdo->prepare($sql);
    if ($stmt->execute([$username, $password, $email, $firs_name, $last_name, $permission, $user_id])) {
        header("Location: $base_url/page-users.php");
    } else {
        header("Location: $base_url/something-went-wrong.php?code=500");
    }
}

$pdo = null;

