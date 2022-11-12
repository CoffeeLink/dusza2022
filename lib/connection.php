<?php

use Firebase\JWT\JWT;
use Firebase\JWT\Key;
require_once(__DIR__."/../vendor/autoload.php");

function connect_mysql() {
    $config = require(__DIR__."/../config/config.php");
    $db = new PDO('mysql:host=' . $config['db_host'] . ';dbname=' . $config['db_name'], $config['db_user'], $config['db_password']);
    return $db;
}

function authorize($username, $password) {
    $db = connect_mysql();
    $query = $db->prepare('SELECT * FROM users WHERE user_name = :username AND password = :password');
    $query->execute([
        'username' => $username,
        'password' => $password
    ]);
    $result = $query->fetch(PDO::FETCH_ASSOC);
    $db = null;
    return $result;
}

function get_user_by_id($id) {
    $db = connect_mysql();
    $query = $db->prepare('SELECT * FROM users WHERE user_id = :id');
    $query->execute([
        'id' => $id
    ]);
    $result = $query->fetch(PDO::FETCH_ASSOC);
    $db = null;
    return $result;
}

function validate_token($token) {
    $config = require(__DIR__."/../config/config.php");
    $decoded = JWT::decode($token, new Key($config['jwt_secret'], 'HS512'));
    $user = get_user_by_id($decoded->uid);
    if ($user) {
        return true;
    } else {
        return false;
    }
}