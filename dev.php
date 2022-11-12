<?php

require __DIR__ . "/lib/connection.php";

echo checkPermission($_COOKIE['token'], "EDITOR");