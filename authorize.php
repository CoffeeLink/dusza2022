<?php

use Firebase\JWT\JWT;
require "lib/connection.php";
require_once(__DIR__ . '../vendor/autoload.php');

$username = $_POST['username'];
$password = hash('sha256', $_POST['password']);

if (array_key_exists('username', $_POST) && array_key_exists('password', $_POST)) {
    $user = authorize($username, $password);
    if ($user) {
        var_dump($user);
        $config = require(__DIR__ . '../config/config.php');
        $date = new DateTime();
        $expire_at = $date->modify("+1 day")->getTimestamp();
        $domainName = $_SERVER['HTTP_HOST'];
        $uid = $user['user_id'];
        var_dump($config);
        
        
        $request_data = [
            'iat' => time(),
            'exp' => $expire_at,
            'uid' => $uid,
            'iss' => $domainName,
            'nbf' => time(),
        ];
        
        $jwt = JWT::encode($request_data, $config['jwt_secret'], 'HS512');
        setcookie('token', $jwt, $expire_at, '/', $domainName, false, true);
        header('Location: /');
    } else {
        header('Location: /login.php');
    }
} else {
    header('Location: /login.php');
}

?>