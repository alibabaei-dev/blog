<!DOCTYPE html>
<html lang="fa">
<head>
    <meta charset="UTF-8">
    <title>ایجاد پست جدید</title>
<link rel="stylesheet" href="/myblog-project/public/css/create.css">
<?php 
$pageTitle = "ایجاد پست جدید";
require_once __DIR__ . '/../layouts/header.php'; 
?>

</head>
<body>

<main class="create-form-container">
    <h1>ایجاد پست جدید</h1>

<form action="/myblog-project/public/index.php?action=store" method="POST" enctype="multipart/form-data">
    <label for="title">عنوان:</label>
    <input type="text" id="title" name="title" required>

    <label for="body">متن پست:</label>
    <textarea id="body" name="body" rows="7" required></textarea>

    <label for="image">تصویر:</label>
    <input type="file" id="image" name="image" accept="image/*">

    <label for="is_featured">
        <input type="checkbox" id="is_featured" name="is_featured" value="1">
        این پست ویژه باشد
    </label>
    <label for="category">دسته‌بندی:</label>
    <select name="category_id" id="category">
        <option value="">انتخاب دسته‌بندی</option>
        <?php foreach ($categories as $category): ?>
            <option value="<?= $category['id']; ?>"><?= htmlspecialchars($category['name']); ?></option>
        <?php endforeach; ?>
    </select>
    <button type="submit">ثبت پست</button>
</form>


</main>

<footer class="main-footer">
    <div class="container">
<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
    </div>
</footer>

</body>
</html>
