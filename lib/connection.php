<?php
//JWT token validation
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
require_once(__DIR__."/../vendor/autoload.php");

//szimpla mysql kapcsolat létrehozása a config.php-ban megadott adatok alapján
function connect_mysql() {
    $config = require(__DIR__."/../config/config.php");
    $db = new PDO('mysql:host=' . $config['db_host'] . ';dbname=' . $config['db_name'], $config['db_user'], $config['db_password']);
    return $db;
}

//megnézi, hogy a login évrényes-e, Ha igen, akkor visszaadja a felhasználó adatait
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

//id alapu felhasználó lekérdezés
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

//JWT token ellenőrzése, ha érvényes, akkor visszaadja a felhasználó ID-ját
function validate_token($token) {
    $config = require(__DIR__."/../config/config.php");
    $decoded = JWT::decode($token, new Key($config['jwt_secret'], 'HS512'));
    $user = get_user_by_id($decoded->uid);
    if ($user) {
        return $user['user_id'];
    } else {
        return false;
    }
}

function getAllPosibleLevels($permission) {
    $AllLevels = [
        'EDITOR' => 1,
        'MODERATOR' => 2,
        'WEBMASTER' => 3,
    ];
    $levels = [];
    $plevel = $AllLevels[$permission];
    foreach ($AllLevels as $key => $value) {
        if ($value <= $plevel) {
            $levels[] = $key;
        }
    }
    return $levels;

}

//Megnézi hogy a felhasználo nak van-e jogosultsága, ha igen, akkor True, ha nem, akkor False, JWT token alapján
function checkPermission($token, $permission) {
    $id = validate_token($token);
    if ($id) {
        $db = connect_mysql();
        $query = $db->prepare('SELECT * FROM users WHERE user_id = :id');
        $query->execute([
            'id' => $id
        ]);
        $result = $query->fetch(PDO::FETCH_ASSOC);
        $db = null;
        $perms = getAllPosibleLevels($result['permission']);
        echo $result['permission'];
        var_dump($perms);
        if (in_array($permission, $perms)) {
            return true;
        } else {
            return false;
        }
    } else {
        return false;
    }
}
