<?php

require_once __DIR__ . '/../core/Database.php';
require_once __DIR__ . '/Content.php';

class Post extends Content {
    private $id;
    private $pdo_post;
    private $imagePath;
    private $is_featured;
    private $category_id;

    public function __construct($id = null, $title = null, $body = null, $category_id = null, $imagePath = null, $is_featured = 0) {
        $this->id = $id;
        parent::__construct($title, $body, $category_id);
        $this->imagePath = $imagePath;
        $this->is_featured = $is_featured;

        $db = new Database();
        $this->pdo_post = $db->getConnection();
    }

    public function getId() {
        return $this->id;
    }

    public function isFeatured() {
        return $this->is_featured;
    }

    public function getImagePath() {
        return $this->imagePath;
    }

    public function getCategoryId() {
        return $this->category_id;
    }

    public function getAllPosts() {
        $stmt = $this->pdo_post->prepare("SELECT * FROM posts");
        $stmt->execute();
        $postsData = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $posts = [];
        foreach ($postsData as $data) {
            $posts[] = new Post(
                $data['id'],
                $data['title'],
                $data['body'],
                $data['category_id'] ?? null,
                $data['image'] ?? null,
                $data['is_featured'] ?? 0
            );
        }

        return $posts;
    }
public function getByCategory($categoryId)
{
    $stmt = $this->pdo_post->prepare("SELECT * FROM posts WHERE category_id = ?");
    $stmt->execute([$categoryId]);
    $postsData = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $posts = [];
    foreach ($postsData as $data) {
        $posts[] = new Post(
            $data['id'],
            $data['title'],
            $data['body'],
            $data['category_id'] ?? null,
            $data['image'] ?? null,
            $data['is_featured'] ?? 0
        );
    }

    return $posts;
}

    public function find($id) {
        $stmt = $this->pdo_post->prepare("SELECT * FROM posts WHERE id = ?");
        $stmt->execute([$id]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($data) {
            return new self(
                $data['id'],
                $data['title'],
                $data['body'],
                $data['category_id'],
                $data['image'] ?? null,
                $data['is_featured'] ?? 0
            );
        }

        return null;
    }

    public function createPost($title, $body, $image, $is_featured, $categoryId) {
        $stmt = $this->pdo_post->prepare("
            INSERT INTO posts (title, body, image, is_featured, category_id)
            VALUES (:title, :body, :image, :is_featured, :category_id)
        ");
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':body', $body);
        $stmt->bindParam(':image', $image);
        $stmt->bindParam(':is_featured', $is_featured, PDO::PARAM_INT);
        $stmt->bindParam(':category_id', $categoryId, PDO::PARAM_INT);

        return $stmt->execute();
    }

    public function getPostById($id) {
        return $this->find($id);
    }

    
}
