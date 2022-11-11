<?php

use Firebase\JWT\JWT;
require_once(__DIR__ . '../vendor/autoload.php');

$username = $_POST['username'];
$password = $_POST['password'];

if (array_key_exists('username', $_POST) && array_key_exists('password', $_POST)) {
    $user = authorize($username, $password);
    if ($user) {
        $config = require_once(__DIR__ . '../config/config.php');
        $secret_key = $config['jwt_secret'];
        $date = new DateTime();
        $expire_at = $date->modify("+1 day")->getTimestamp();
        $domainName = $_SERVER['HTTP_HOST'];
        
        
        $request_data = [
            'iat' => time(),
            'exp' => $expire_at,
            'uid' => $uid,
            'iss' => $domainName,
            'nbf' => time(),
        ];
        
        $jwt = JWT::encode($request_data, $secret_key, 'HS512');
        setcookie('token', $jwt, $expire_at, '/', $domainName, false, true);
        header('Location: /');
    } else {
        header('Location: /login.php');
    }
} else {
    header('Location: /login.php');
}

$config = require_once(__DIR__ . '../config/config.php');
$secret_key = $config['jwt_secret'];
$date = new DateTime();
$expire_at = $date->modify("+1 day")->getTimestamp();
$domainName = $_SERVER['HTTP_HOST'];


$request_data = [
    'iat' => time(),
    'exp' => $expire_at,
    'uid' => $uid,
    'iss' => $domainName,
    'nbf' => time(),
];

$jwt = JWT::encode($request_data, $secret_key, 'HS512');
setcookie('token', $jwt, $expire_at, '/', $domainName, false, true);
echo $jwt;

?>