<?php

require_once __DIR__ . '/Controller.php'; 
require_once __DIR__ . '/../models/Post.php';
require_once __DIR__ . '/../models/Category.php';

class PostController extends Controller {

public function index() {
    $postModel = $this->model('Post');
    
    if (isset($_GET['category_id']) && is_numeric($_GET['category_id'])) {
        $categoryId = $_GET['category_id'];
        $posts = $postModel->getByCategory($categoryId);
    } else {
        $posts = $postModel->getAllPosts();
    }

    $categoryModel = $this->model('Category');
    $categories = $categoryModel->all();

    $this->view('posts/index', [
        'posts' => $posts,
        'categories' => $categories
    ]);
}


public function create()
{
    $categoryModel = new Category();
    $categories = $categoryModel->all();

    require_once '../app/views/posts/create.php';
}
    public function store() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $title = $_POST['title'] ?? '';
            $body = $_POST['body'] ?? '';
            $categoryId = $_POST['category_id'];
            $is_featured = isset($_POST['is_featured']) ? 1 : 0;
            $imagePath = null;
            

            // آپلود تصویر
            if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
                $uploadDir = __DIR__ . '/../../public/uploads/';
                if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);

                $filename = time() . '-' . basename($_FILES['image']['name']);
                $targetPath = $uploadDir . $filename;

                if (move_uploaded_file($_FILES['image']['tmp_name'], $targetPath)) {
                    $imagePath = 'uploads/' . $filename;
                }
            }

            $postModel = $this->model('Post');
$postModel->createPost($title, $body, $imagePath, $is_featured, $categoryId);

            header('Location: index.php?action=index');
            exit();
        }
    }
public function show()
{
    $id = $_GET['id'] ?? null;

    if (!$id || !is_numeric($id)) {
        echo "شناسه پست نامعتبر است.";
        return;
    }

    $postModel = $this->model('Post');
    $post = $postModel->find($id);

    if (!$post) {
        echo "پست مورد نظر یافت نشد.";
        return;
    }

    $categoryModel = $this->model('Category');
$category = $categoryModel->find($post->getCategoryId());

    $this->view('posts/show', [
        'post' => $post,
        'category' => $category
    ]);
}
}
