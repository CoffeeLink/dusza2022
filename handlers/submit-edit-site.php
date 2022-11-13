<?php
require __DIR__ . "/../lib/utils.php";
$base_url = (require __DIR__ . "/../config/config.php")['base_url'];

session_start(); // Start the session.

$token = $_SESSION['jwt_token'] ?? null;

if(!checkPermission($token, 'WEBMASTER')) {
  header("Location: $base_url/");

  return;
}

$name = $_POST['site_name'];
$description = $_POST['description'];
$email = $_POST['email'];
$icon = $_POST['icon'];

echo $icon;

$settings = [
  'name' => $name,
  'description' => $description,
  'email' => $email,
  'icon' => $icon
];

$newJsonString = json_encode($settings);
file_put_contents(__DIR__ . "/../settings/settings.json", $newJsonString);

//header("Location: $base_url/edit-site.php");

?>