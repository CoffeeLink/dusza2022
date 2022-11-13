<?php

session_start(); // Start the session.

use Firebase\JWT\JWT;
require __DIR__ . "/../lib/utils.php";
require_once(__DIR__ . '/../vendor/autoload.php');
$config = require(__DIR__ . '/../config/config.php');
$base_url = (require __DIR__ . "/../config/config.php")['base_url'];

$token = $_SESSION['jwt_token'] ?? null;

$username = $_POST['username'];
$password = hash('sha256', $_POST['password']);
$email = $_POST['email'];
$first_name = $_POST['first_name'];
$last_name = $_POST['last_name'];
$permission = $_POST['permission'];

if (array_key_exists('jwt_token', $_SESSION) and checkPermission($token, "WEBMASTER")) {
    if (array_key_exists('username', $_POST) && array_key_exists('password', $_POST) && array_key_exists('email', $_POST) && array_key_exists('first_name', $_POST) && array_key_exists('last_name', $_POST) && array_key_exists('permission', $_POST)) {
        $user = registerNewUser($email, $password, $username, $first_name, $last_name, $permission);
        if ($user) {
            header("location: $base_url/page-users.php");
        } else {
            header("location: $base_url/something-went-wrong.php?errorTitle=Regisztrácios Hiba&errorMessage=Hiba történt a felhasználó létrehozásakor!&errorCode=MYSQL_ERROR");
        }
    } else {
        header("location: $base_url/something-went-wrong.php?errorTitle=Regisztrácios Hiba&errorMessage=Hiba történt a felhasználó létrehozásakor!&errorCode=POST_ERROR");
    }
} else {
    header("Location: $base_url/something-went-wrong.php?code=403");
}