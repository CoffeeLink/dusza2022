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
  <h1>Hi</h1>
  <button onclick="window.location.href='/login.php';">login</button>
  <?php
  if (isset($_COOKIE['token'])) {
    echo '<h1>U are logged in</h1>';
    echo '<button onclick="setCookie("token", "logging out", 0.00001);">logout</button>';
  }
  ?>
</body>
</html>