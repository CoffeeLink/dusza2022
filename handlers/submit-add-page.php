<?php

$title = $_POST['title'];
$description = $_POST['description'];
$content = $_POST['content'];

// Import config
$config = require_once __DIR__ . '/../config/config.php';

// Connect to database
$connection = mysqli_connect($config['db_host'], $config['db_user'], $config['db_password'], $config['db_name']);

// Check connection
if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
}

// Insert data into database
$sql = "INSERT INTO pages (parent_page_id, title, description, content, is_visible, created_at, edited_at, created_by_user_id, edited_by_user_id) VALUES (NULL, ?, ?, ?, 1, NOW(), NOW(), 1, 1)";

// Prepare statement
$stmt = $connection->prepare($sql);

// Bind parameters
$stmt->bind_param("sss", $title, $description, $content);

// Execute statement
$stmt->execute();

// Redirect the user to the home page
header('Location: /');

?>
