<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="/css/main.css">
    <script defer src="/js/app.js"></script>
</head>
<body>
    <form action="" method="post">
        <input type="text" name="username" placeholder="Username">
        <input type="password" name="password" placeholder="Password">
        <input type="text" name="email" placeholder="Your Email">
        <input type="text" name="firstname" placeholder="Your First Name">
        <input type="text" name="lastname" placeholder="Your Last Name">
        <input type="submit" value="Register" id="#frmRegister">
    </form>
</body>
</html>
<?php
require "lib/connection.php";
require_once(__DIR__ . '../vendor/autoload.php');

if (array_key_exists('username', $_POST) and array_key_exists('password', $_POST) and array_key_exists('email', $_POST) and array_key_exists('firstname', $_POST) and array_key_exists('lastname', $_POST)) {
    $username = $_POST['username'];
    $password = hash("sha256", $_POST['password']);
    $email = $_POST['email'];
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    registerNewUser($email, $password, $username, $firstname, $lastname);
    header('Location: /login.php');
}

