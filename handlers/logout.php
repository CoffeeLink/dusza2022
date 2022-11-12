<?php
session_start();
unset($_SESSION['jwt_token']);
header("Location: $base_url/");
session_destroy();
?>