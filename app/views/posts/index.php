<?php 
require_once __DIR__ . '/../layouts/header.php'; 
?>

<main class="homepage layout">
    <aside class="category-list">
        <h2>دسته‌بندی‌ها</h2>
        <ul>
            <?php foreach ($categories as $category): ?>
                <li><a href="index.php?action=index&category_id=<?= $category['id'] ?>">
                    <?= htmlspecialchars($category['name']) ?>
                </a></li>
            <?php endforeach; ?>
        </ul>
    </aside>

    <section class="main-content">
        <?php if (!empty($featuredPosts)): ?>
            <section class="featured-post container">
                <h2 class="section-title">پست‌های ویژه</h2>
                <div class="post-grid">
                    <?php foreach ($featuredPosts as $f): ?>
                        <article class="post-item featured">
                            <img src="<?= htmlspecialchars($f->getImageSrc()) ?>" alt="Featured Post">
                            <h3><a href="index.php?action=show&id=<?= $f->getId() ?>"><?= htmlspecialchars($f->getTitle()) ?></a></h3>
                            <p><?= htmlspecialchars($f->getSummary(150)) ?></p>
                        </article>
                    <?php endforeach; ?>
                </div>
            </section>
        <?php endif; ?>

        <h2 class="section-title">آخرین پست‌ها</h2>
        <section class="post-grid container">
            <?php if (!empty($normalPosts)): ?>
                <?php foreach ($normalPosts as $post): ?>
                    <article class="post-item">
                        <img src="<?= htmlspecialchars($post->getImageSrc()) ?>" alt="Post">
                        <h3><a href="index.php?action=show&id=<?= $post->getId() ?>"><?= htmlspecialchars($post->getTitle()) ?></a></h3>
                        <div class="post-body">
                            <p><?= htmlspecialchars($post->getSummary()) ?></p>
                        </div>
                    </article>
                <?php endforeach; ?>
            <?php else: ?>
                <p>هیچ پستی وجود ندارد.</p>
            <?php endif; ?>
        </section>
    </section>
</main>
<?php 
require_once __DIR__ . '/../layouts/footer.php'; 
?>
