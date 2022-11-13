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

$user_id = $_POST['user_id'];
$username = $_POST['username'];
$password = hash("sha256", $_POST['password']);
$email = $_POST['email'];
$firs_name = $_POST['first_name'];
$last_name = $_POST['last_name'];
$permission = $_POST['permission'];

$pdo = connect_mysql();
$sql = "UPDATE users SET user_name = :username, password = :password, email = :email, first_name = :first_name, last_name = :last_name, permission = :permission WHERE user_id = :user_id";
$stmt = $pdo->prepare($sql);
if ($stmt->execute([
    'username' => $username,
    'password' => $password,
    'email' => $email,
    'first_name' => $firs_name,
    'last_name' => $last_name,
    'permission' => $permission,
    'user_id' => $user_id
])) {
    header("Location: $base_url/page-users.php");
} else {
    header("Location: $base_url/something-went-wrong.php?code=500");
}

