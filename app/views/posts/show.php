<?php 
$pageTitle = htmlspecialchars($post->getTitle());
require_once __DIR__ . '/../layouts/header.php'; 
?>

<main class="single-post">
    <h2><?= $pageTitle ?></h2>

    <p><?= nl2br(htmlspecialchars($post->getBody())) ?></p>
    <img src="<?= $post->getImageSrc() ?>" alt="<?= $pageTitle ?>" style="max-width:100%; border-radius:12px; margin-bottom: 1rem;">
    <a class="back-link" href="index.php?action=index">← بازگشت به لیست پست‌ها</a>
</main>

<footer class="main-footer">
    <div class="container">
        <?php require_once __DIR__ . '/../layouts/footer.php'; ?>
    </div>
</footer>
