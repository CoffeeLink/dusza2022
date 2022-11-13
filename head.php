<?php
  // Global head elements and scripts for all pages

  $settings = json_decode(file_get_contents(__DIR__ . "/settings/settings.json"), true);
?>

<link href="data:image/x-icon;base64,<?= $settings['icon'] ?>" rel="icon" type="image/x-icon" />
<!-- Pay attention to not overwrite the title when including this file -->
<title><?= $settings['name'] ?></title>