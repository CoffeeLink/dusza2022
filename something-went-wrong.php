<?php
$errorTitle = $_GET['errorTitle'] ?? 'Hiba történt';
$errorDescription = $_GET['errorDescription'] ?? 'Hiba történt';
$errorCode = $_GET['errorCode'] ?? '500';

echo "<h1>" . htmlspecialchars($errorTitle) . "</h1>";
echo "<p>" . htmlspecialchars($errorDescription) . "</p>";
echo "<p>" . htmlspecialchars($errorCode) . "</p>";
?>