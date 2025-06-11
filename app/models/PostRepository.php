<?php

class PostRepository {
    private $db;

    public function __construct(PDO $dbConnection) {
        $this->db = $dbConnection;
    }

    public function getAllPosts(): array {
        try {
            $stmt = $this->db->prepare("SELECT * FROM posts ORDER BY created_at DESC");
            $stmt->execute();
            $postsData = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $posts = [];
            foreach ($postsData as $data) {
                $posts[] = new PostEntity(
                    $data['id'],
                    $data['title'],
                    $data['body'],
                    $data['category_id'] ?? null,
                    $data['image'] ?? null,
                    $data['is_featured'] ?? 0,
                    $data['created_at'] ?? null
                );
            }
            return $posts;
        } catch (PDOException $e) {
            error_log("PostRepository Error - getAllPosts(): " . $e->getMessage());
            throw new Exception("Could not retrieve posts. Please try again later.", 0, $e);
        }
    }

    public function getByCategory($categoryId): array {
        try {
            $stmt = $this->db->prepare("SELECT * FROM posts WHERE category_id = ? ORDER BY created_at DESC");
            $stmt->execute([$categoryId]);
            $postsData = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $posts = [];
            foreach ($postsData as $data) {
                $posts[] = new PostEntity(
                    $data['id'],
                    $data['title'],
                    $data['body'],
                    $data['category_id'] ?? null,
                    $data['image'] ?? null,
                    $data['is_featured'] ?? 0,
                    $data['created_at'] ?? null
                );
            }
            return $posts;
        } catch (PDOException $e) {
            error_log("PostRepository Error - getByCategory($categoryId): " . $e->getMessage());
            throw new Exception("Could not retrieve posts by category. Please try again later.", 0, $e);
        }
    }

    public function find($id): ?PostEntity {
        try {
            $stmt = $this->db->prepare("SELECT * FROM posts WHERE id = ?");
            $stmt->execute([$id]);
            $data = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$data) {
                return null;
            }

            return new PostEntity(
                $data['id'],
                $data['title'],
                $data['body'],
                $data['category_id'] ?? null,
                $data['image'] ?? null,
                $data['is_featured'] ?? 0,
                $data['created_at'] ?? null
            );
        } catch (PDOException $e) {
            error_log("PostRepository Error - find($id): " . $e->getMessage());
            throw new Exception("Could not find post. Please try again later.", 0, $e);
        }
    }

    public function createPost(PostEntity $post): int {
        try {
            $stmt = $this->db->prepare("
                INSERT INTO posts (title, body, image, is_featured, category_id, created_at)
                VALUES (:title, :body, :image, :is_featured, :category_id, NOW())
            ");
            $stmt->bindParam(':title', $post->title);
            $stmt->bindParam(':body', $post->body);
            $stmt->bindParam(':image', $post->image_path);
            $stmt->bindParam(':is_featured', $post->is_featured, PDO::PARAM_INT);
            $stmt->bindParam(':category_id', $post->category_id, PDO::PARAM_INT);

            $stmt->execute();
            return $this->db->lastInsertId();
        } catch (PDOException $e) {
            error_log("PostRepository Error - createPost(): " . $e->getMessage());
            throw new Exception("Could not create post. Please try again later.", 0, $e);
        }
    }
}
