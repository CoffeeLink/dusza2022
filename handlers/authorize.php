<?php

session_start(); // Start the session.

use Firebase\JWT\JWT;
require __DIR__ . "/../lib/utils.php";
require_once(__DIR__ . '/../vendor/autoload.php');
$config = require(__DIR__ . '/../config/config.php');
$base_url = (require __DIR__ . "/../config/config.php")['base_url'];

$username = $_POST['username'];
$password = hash('sha256', $_POST['password']);

if (array_key_exists('username', $_POST) && array_key_exists('password', $_POST)) {
    $user = authorize($username, $password);
    if ($user) {
        $date = new DateTime();
        $expire_at = $date->modify("+1 day")->getTimestamp();
        $domainName = $_SERVER['HTTP_HOST'];
        $uid = $user['user_id'];
        
        $request_data = [
            'iat' => time(),
            'exp' => $expire_at,
            'uid' => $uid,
            'iss' => $domainName,
            'nbf' => time(),
        ];
        
        $jwt = JWT::encode($request_data, $config['jwt_secret'], 'HS512');
        $_SESSION['jwt_token'] = $jwt;
        header("Location: $base_url/");
    } else {
        header("Location: $base_url/login.php?error=1");
    }
} else {
    header("Location: $base_url/login.php");
}

?>