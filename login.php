<?php
require __DIR__ . "/lib/connection.php";
require_once(__DIR__ . '../vendor/autoload.php');
$base_url = (require __DIR__ . "/config/config.php")['base_url'];

if (isset($_COOKIE['token']) and $_COOKIE['token'] != '') {
    if (validate_token($_COOKIE['token'])) {
        header("Location: $base_url/");
    } else {
        header("Location: $base_url/login.php");
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="./css/main.css">
    <script defer src="./js/app.js"></script>
</head>

<body>
    <form action="./handlers/authorize.php" method="POST">
        <input type="text" name="username" placeholder="Username">
        <input type="password" name="password" placeholder="Password">
        <input type="submit" value="Login" id="#frmLogin">
    </form>
</body>

</html>