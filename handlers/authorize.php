<?php

use Firebase\JWT\JWT;
require_once(__DIR__ . '../vendor/autoload.php');

$username = $_POST['username'];
$password = $_POST['password'];

if (empty($username) || empty($password)) {
    header('Location: /login.php');
    exit();
} else {
    $config = require_once(__DIR__ . '../config/config.php');
    $secret_key = $config['jwt_secret'];

    $date = new DateTime();
    $expire_at = $date->modify("+1 day")->getTimestamp();
    $domainName = $_SERVER['HTTP_HOST'];
    
    // TEMP CODE
    $uid = 0;
    if ($username == 'admin' && $password == 'admin') {
        $uid = 1;
    }
    // TEMP CODE

    $request_data = [
        'iat' => time(),
        'exp' => $expire_at,
        'uid' => $uid,
        'iss' => $domainName,
        'nbf' => time(),
    ];
    
    $jwt = JWT::encode($request_data, $secret_key, 'HS512');

    echo $jwt;
}

$config = require_once __DIR__ . '/config/config.php';


?>