<?php

require_once PROJECT_ROOT_PATH . "/Model/Database.php";

class UserModel extends Database
{
    public function getUsers($limit)
    {
        return $this->select("SELECT * FROM users ORDER BY user_id ASC LIMIT ?", ["i", $limit]);
    }

    public function getUserPassword($username)
    {
        return $this->select("SELECT password FROM users WHERE username = ?", ["s", $username]);
    }

    public function getUserRole($username)
    {
        return $this->select("SELECT user_status FROM users WHERE username = ?", ["s", $username]);
    }
}
