<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Hi</title>
  <link rel="stylesheet" href="/css/main.css">
  <script defer src="/js/app.js"></script>
</head>

<body>
<?php

if (!isset($_COOKIE['token'])) {
  header('Location: /login.php');
} else {
  header('Location: /');
}

?>
</body>
</html>