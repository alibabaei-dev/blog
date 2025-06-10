<?php 
$pageTitle = htmlspecialchars($post->getTitle());
require_once __DIR__ . '/../layouts/header.php'; 
?>

<!DOCTYPE html>
<html lang="fa">
<head>
    <meta charset="UTF-8">
    <title><?= $pageTitle ?></title>
<link rel="stylesheet" href="/myblog-project/public/css/content.css">
    <style>
    </style>
</head>
<body>

<main class="single-post">
    <h2><?= $pageTitle ?></h2>


    <p><?= nl2br(htmlspecialchars($post->getBody())) ?></p>
    <img src="/myblog-project/public/<?= htmlspecialchars($post->getImagePath() ?? 'images/default.jpg') ?>" alt="<?= $pageTitle ?>" style="max-width:100%; border-radius:12px; margin-bottom: 1rem;">
    <a class="back-link" href="index.php?action=index">← بازگشت به لیست پست‌ها</a>
</main>

<footer class="main-footer">
    <div class="container">
        <?php require_once __DIR__ . '/../layouts/footer.php'; ?>
    </div>
</footer>

</body>
</html>
