<?php

class Comment {
    public $id;
    public $content;
    public $user_id;
    public $username;
    public $article_id;
    public $created_at;

    public function __construct($id, $content, $user_id, $username, $article_id, $created_at) {
        $this->id = $id;
        $this->content = $content;
        $this->user_id = $user_id;
        $this->username = $username;
        $this->article_id = $article_id;
        $this->created_at = $created_at ?: date('Y-m-d H:i:s'); 
    }

    public static function find_by_article($article_id) {
        $db = Db::getInstance();
        $article_id = mysqli_real_escape_string($db, $article_id);    

        $query = "SELECT c.id, c.content, c.user_id, c.article_id, c.created_at, u.username 
                  FROM comments c
                  JOIN users u ON c.user_id = u.id 
                  WHERE c.article_id = $article_id";
        
        $result = $db->query($query);
        $comments = [];

        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $comment = new Comment(
                    $row['id'], 
                    $row['content'], 
                    $row['user_id'], 
                    $row['username'],  
                    $row['article_id'], 
                    $row['created_at']
                );
                $comments[] = $comment;
            }
        }
        return $comments;
    }

    public static function create($content, $user_id, $article_id) {
        $db = Db::getInstance();
        $content = mysqli_real_escape_string($db, $content);
        $user_id = (int) $user_id;  
        $article_id = (int) $article_id;  

        $query = "INSERT INTO comments (content, user_id, article_id) 
                  VALUES ('$content', $user_id, $article_id)";

        return $db->query($query);
    }
}
?>
