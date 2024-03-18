<?php

require_once PROJECT_ROOT_PATH . "/Model/Database.php";

class PostModel extends Database
{
    public function getPosts($limit)
    {
        return $this->select("SELECT * FROM posts ORDER BY user_id ASC LIMIT ?", ["i", $limit]);
    }

    public function addPost($postId){}

    public function deletePost($postId){}

}