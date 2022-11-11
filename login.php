<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="/css/main.css">
    <script defer src="/js/app.js"></script>
</head>

<?php

use Firebase\JWT\JWT;
require "lib/connection.php";
require_once(__DIR__ . '../vendor/autoload.php');

if (isset($_COOKIE['token'] ) and $_COOKIE['token'] != '') {
    if (validate_token($_COOKIE['token'])) {
        header('Location: /');
    } else {
        header('Location: /login.php');
    }
}

?>

<body>
    <form action="/authorize.php" method="POST">
        <input type="text" name="username" placeholder="Username">
        <input type="password" name="password" placeholder="Password">
        <input type="submit" value="Login" id="#frmLogin">
    </form>
</body>
</html>