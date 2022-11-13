<?php
require __DIR__ . "/lib/utils.php";
$base_url = (require __DIR__ . "/config/config.php")['base_url'];

session_start(); // Start the session.

$token = $_SESSION['jwt_token'] ?? null;

if (!checkPermission($token, 'MODERATOR')) {
  header("Location: $base_url/");

  return;
}

$page_id = $_GET['page'];

$pdo = connect_mysql();

$sql = "SELECT * FROM pages WHERE page_id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$page_id]);
$page = $stmt->fetch(PDO::FETCH_ASSOC);
$page_title = "Szerkesztés";

if (!$page) {
  header("Location: $base_url/");
}

$title = $page['title'];
$description = $page['description'];
$content = $page['content'];

$pdo = null;
include __DIR__ . "/header.php";
?>

<body>
    <h1>Szerkesztés: <?php echo htmlspecialchars($title); ?></h1>
    <form action="./handlers/submit-edit-page.php" method="POST">
        <input type="hidden" name="page_id" value="<?php echo htmlspecialchars($page_id); ?>">
        <input type="text" name="title" placeholder="Title" value="<?php echo htmlspecialchars($title); ?>">
        <input type="text" name="description" placeholder="Description"
            value="<?php echo htmlspecialchars($description); ?>">
        <textarea name="content" id="content-editor" cols="30" rows="10"
            placeholder="Content"><?php echo htmlspecialchars($content); ?></textarea>
        <input type="submit" value="Save">
    </form>

    <?php
  include __DIR__ . "./footer.php";
  ?>