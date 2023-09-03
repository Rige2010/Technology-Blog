<?php

class Database
{
    private $host = "localhost";
    private $db = "blog_db";
    private $user = "root";
    private $password = "";

    private $dsn;
    private $opt = [
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ];

    public function __construct()
    {
        $this->dsn = "mysql:host=$this->host;dbname=$this->db";
        $this->db = new PDO($this->dsn, $this->user, $this->password, $this->opt);
    }


    private function set_queryDb(string $query, ...$params)
    {
        $stmt = $this->db->prepare($query);
        $stmt->execute($params);
    }

    private function get_queryDb(string $query, ...$params)
    {
        $stmt = $this->db->prepare($query);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    // 
    // User functions

    public function add_user($email, $password)
    {
        $hpassword = password_hash($password, PASSWORD_DEFAULT);
        $this->set_queryDb("INSERT INTO `users` (`email`, `password`) VALUES (?, ?)", $email, $hpassword);
    }

    function exists_user($email): array
    {
        return $this->get_queryDb("SELECT `email` FROM `users` WHERE email = ?", $email);
    }

    function get_user_pass($email): string
    {
        $result = $this->get_queryDb("SELECT `password` FROM `users` WHERE `email` = ?", $email);
        return $result[0]["password"];
    }

    // 
    // Articles functions

    public function get_articles_orderDesc($count, $page): array
    {
        $offset = (($page - 1) * $count);
        return $this->get_queryDb("SELECT `id`, `header`, `short_desc`, `date` FROM `articles` ORDER BY `id` DESC LIMIT $count OFFSET $offset");
    }

    public function get_articles_count(): int
    {
        $count = 0;
        $result = $this->get_queryDb("SELECT `id` FROM `articles`");
        foreach (($result) as $id) {
            $count++;
        }
        return $count;
    }

    public function get_article($id): array
    {
        $result = $this->get_queryDb("SELECT `header`, `short_desc`, `description`, `date` FROM `articles` WHERE `id` = ?", $id);
        return $result[0];
    }

    // Comments functions

    public function add_comment($name, $text, $article_id)
    {
        $this->set_queryDb("INSERT INTO `comments` (`name`,`text`, `article_id`) VALUES (?, ?, ?)", $name, $text, $article_id);
    }

    public function get_comments($article_id): array
    {
        return $this->get_queryDb("SELECT `name`, `text`, `date` FROM `comments` WHERE `article_id` = ? ORDER BY `date` DESC", $article_id);
    }
}
