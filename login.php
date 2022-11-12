<?php
require __DIR__ . "/lib/connection.php";
require_once(__DIR__ . '../vendor/autoload.php');
$base_url = (require __DIR__ . "/config/config.php")['base_url'];

session_start();
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
    <?php
    $error = $_GET['error'] ?? null;
    if ($error == 1) {
        echo "<p>Invalid username or password</p>";
    }
    ?>
</body>

</html>