<?php
require __DIR__ . "/../config/config.php";
require_once __DIR__ . "/../lib/utils.php";
$base_url = (require __DIR__ . "/../config/config.php")['base_url'];

if (!isset($_SESSION)) {
  session_start();
}

$token = $_SESSION['jwt_token'] ?? null;

if (!checkPermission($token, 'MODERATOR')) {
  header("Location: $base_url/somsthing-went-wrong.php?code=403");

  return;
}
?>

</div>
<script>
  document.getElementById("<?= $aktiv_menu ?>").classList.add("active");
  document.getElementById("<?= $aktiv_menu ?>").classList.remove("link-dark");
</script>
</body>

</html>