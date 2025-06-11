<?php
class PostEntity {
    public $id;
    public $title;
    public $body;
    public $image_path;
    public $is_featured;
    public $category_id;
    public function __construct($id = null, $title = null, $body = null, $category_id = null, $imagePath = null, $is_featured = 0, $createdAt = null) {
        $this->id = $id;
        $this->title = $title;
        $this->body = $body;
        $this->category_id = $category_id;
        $this->image_path = $imagePath; 
        $this->is_featured = $is_featured;
    }
    public function getId() {
        return $this->id;
    }
    public function getTitle() {
        return $this->title;
    }
    public function getBody() {
        return $this->body;
    }
    public function getCategoryId() {
        return $this->category_id;
    }
    public function getImagePath() {
        return $this->image_path;
    }
    public function isFeatured() {
        return $this->is_featured;
    }
    public function getShortBody($length = 150) {
        if (strlen($this->body) > $length) {
            return substr($this->body, 0, $length) . '...';
        }
        return $this->body;
    }
public function getImageSrc(): string {
    $fullImagePath = $_SERVER['DOCUMENT_ROOT'] . '/myblog/public/' . $this->image_path;

    if (!empty($this->image_path) && file_exists($fullImagePath)) {
        return '/myblog/public/' . htmlspecialchars($this->image_path);
    }

    return '/myblog/public/images/default.png';
}


public function getSummary(int $length = 100): string {
    return htmlspecialchars(mb_substr($this->body, 0, $length)) . '...';
}

}