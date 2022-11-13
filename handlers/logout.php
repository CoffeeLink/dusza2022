<?php
$base_url = (require __DIR__ . "/../config/config.php")['base_url'];

session_start();
unset($_SESSION['jwt_token']);
header("Location: $base_url/");
session_destroy();
?>