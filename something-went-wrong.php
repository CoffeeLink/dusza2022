<?php
$errorTitle = $_GET['errorTitle'] ?? 'Hiba történt';
$errorDescription = $_GET['errorDescription'] ?? 'Hiba történt';
$errorCode = $_GET['errorCode'] ?? '500';

echo "<h1>$errorTitle</h1>";
echo "<p>$errorDescription</p>";
echo "<p>$errorCode</p>";
?>