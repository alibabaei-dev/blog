<?php

class Content {
    protected $title;
    protected $body;
    // protected $category;

    public function __construct($title, $body, $category = null) {
        $this->title = $title;
        $this->body = $body;
        // $this->category = $category;
    }

    public function getSummary() {
        return mb_substr($this->body, 0, 100) . '...';
    }

    public function getTitle() {
        return $this->title;
    }

    // public function getCategory() {
    //     return $this->category;
    // }

    public function getBody() {
        return $this->body;
    }
}
