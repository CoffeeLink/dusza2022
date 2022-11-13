<?php

require __DIR__ . "/../lib/utils.php";
$config = require(__DIR__ . '/../config/config.php');
$base_url = (require __DIR__ . "/../config/config.php")['base_url'];
$search = $_GET['q'] ?? null;
if ($search){
    $pdo = connect_mysql();
    $sql = "SELECT * FROM pages WHERE title LIKE ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(["%$search%"]);
    $pages = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $sql = "SELECT * FROM articles WHERE title LIKE ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(["%$search%"]);
    $articles = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if ($pages) {
        foreach($pages as $page) {
            echo "<a href='$base_url/view-page.php?page=$page[page_id]'>$page[title]</a><br>";
        }
    }
    if ($articles) {
        foreach($articles as $article) {
            echo "<a href='$base_url/view-article.php?article=$article[article_id]'>$article[title]</a><br>";
        }
    }

} else {
    header("Location: $base_url/something-went-wrong.php?errorTitle=No%20search%20term&errorDescription=You%20did%20not%20enter%20a%20search%20term.&errorCode=404");
}