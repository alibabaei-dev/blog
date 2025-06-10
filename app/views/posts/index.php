<!DOCTYPE html>
<html lang="fa">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>وبلاگ من</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<?php 
$pageTitle = "ایجاد پست جدید";
require_once __DIR__ . '/../layouts/header.php'; 
?>

<main class="homepage layout">
    <!-- دسته‌بندی‌ها -->
    <aside class="category-list">
        <h2>دسته‌بندی‌ها</h2>
        <ul>
            <?php foreach ($categories as $category): ?>
                <li>
                    <a href="index.php?action=index&category_id=<?= $category['id'] ?>">
                        <?= htmlspecialchars($category['name']) ?>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
    </aside>

    <!-- محتوای اصلی -->
    <section class="main-content">

        <?php
        $featuredPosts = [];
        foreach ($posts as $p) {
            if ($p->isFeatured()) {
                $featuredPosts[] = $p;
            }
        }
        ?>

        <?php if (!empty($featuredPosts)): ?>
        <section class="featured-post container">
            <h2 class="section-title">پست‌های ویژه</h2>
            <div class="post-grid">
                <?php foreach ($featuredPosts as $f): ?>
                    <article class="post-item featured">
                        <img src="/myblog-project/public/<?= htmlspecialchars($f->getImagePath() ?? 'images/default.jpg') ?>" alt="Featured Post">
                        <h3>
                            <a href="index.php?action=show&id=<?= $f->getId() ?>">
                                <?= htmlspecialchars($f->getTitle()) ?>
                            </a>
                        </h3>
                        <p><?= htmlspecialchars(mb_substr($f->getBody(), 0, 150)) ?>...</p>
                    </article>
                <?php endforeach; ?>
            </div>
        </section>
        <?php endif; ?>

        <h2 class="section-title">آخرین پست‌ها</h2>
        <section class="post-grid container">
            <?php if (!empty($posts)): ?>
                <?php foreach ($posts as $post): ?>
                    <?php
                    $isFeatured = false;
                    foreach ($featuredPosts as $fp) {
                        if ($post->getId() === $fp->getId()) {
                            $isFeatured = true;
                            break;
                        }
                    }
                    if ($isFeatured) continue;
                    ?>
                    <article class="post-item">
                        <img src="/myblog-project/public/<?= htmlspecialchars($post->getImagePath() ?? 'images/default.jpg') ?>" alt="Post">
                        <h3>
                            <a href="index.php?action=show&id=<?= $post->getId() ?>">
                                <?= htmlspecialchars($post->getTitle()) ?>
                            </a>
                        </h3>
                        <p><?= htmlspecialchars(mb_substr($post->getBody(), 0, 100)) ?>...</p>
                    </article>
                <?php endforeach; ?>
            <?php else: ?>
                <p>هیچ پستی وجود ندارد.</p>
            <?php endif; ?>
        </section>
    </section>
</main>

<footer class="main-footer">
    <div class="container">
        <?php require_once __DIR__ . '/../layouts/footer.php'; ?>
    </div>
</footer>

<canvas id="space-canvas"></canvas>
<script src="/myblog-project/public/js/script.js"></script>

</body>
</html>
