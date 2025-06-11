<?php

class PostController extends Controller {

// این قسمت لیست تمام پست ها یا یک کتگوری رو نشون میده
public function index() {
    $postRepository = $this->model('PostRepository');

    if (isset($_GET['category_id']) && is_numeric($_GET['category_id'])) {
        $categoryId = (int)$_GET['category_id'];
        $posts = $postRepository->getByCategory($categoryId);
    } else {
        $posts = $postRepository->getAllPosts();
    }

    $featuredPosts = array_filter($posts, fn($p) => $p->isFeatured());
    $normalPosts = array_filter($posts, fn($p) => !$p->isFeatured());

    $categoryRepository = $this->model('Category'); 
    $categories = $categoryRepository->all();

    $this->view('posts/index', [
        'featuredPosts' => $featuredPosts,
        'normalPosts' => $normalPosts,
        'categories' => $categories,
        'pageTitle' => 'لیست پست‌ها' 
    ]);
}


//صفحه ایجاد پست جدید
public function create() {
    $categoryRepository = $this->model('Category'); 
    $categories = $categoryRepository->all();

    $this->view('posts/create', [
        'categories' => $categories
    ]);
}

    //ایجاد پست
public function store() {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        header('Location: index.php?action=create');
        exit();
    }

    $title = $_POST['title'] ?? '';
    $body = $_POST['body'] ?? '';
    $categoryId = $_POST['category_id'] ?? null;
    $is_featured = isset($_POST['is_featured']) ? 1 : 0;

    // مسیر آپلود
    $uploadDir = ROOT_PATH . 'public/uploads/';
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    $filename = uniqid() . '-' . basename($_FILES['image']['name']);
    $targetPath = $uploadDir . $filename;
    $imagePath = 'uploads/' . $filename;

    move_uploaded_file($_FILES['image']['tmp_name'], $targetPath);

    // ذخیره در دیتابیس
    $postRepository = $this->model('PostRepository');
    $newPost = new PostEntity(null, $title, $body, (int)$categoryId, $imagePath, $is_featured);
    $postRepository->createPost($newPost);

    // ریدایرکت
    header('Location: index.php?action=index');
    exit();
}

//نمایش پست ها بر اساس کتگوری
    public function show() {
    $id = $_GET['id'] ?? null;

    if (!$id || !is_numeric($id)) {
        $this->view('errors/invalid_request', ['message' => 'شناسه پست نامعتبر است.']);
        return;
    }

    $postRepository = $this->model('PostRepository');
    $post = $postRepository->find((int)$id);

    if (!$post) {
        $this->view('errors/not_found', ['message' => 'پست مورد نظر یافت نشد.']);
        return;
    }

    $categoryRepository = $this->model('Category'); 
    $category = $categoryRepository->find($post->getCategoryId());

    $this->view('posts/show', [
        'post' => $post,
        'category' => $category
    ]);
}
}