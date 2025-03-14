
<?php

class Comments{
    public $id;
    public $content;
    public $user_id;
    public $username; 
    public $article_id;
    public $created_at;
    public $username;

    public function __construct($id, $content, $user_id, $username, $article_id, $created_at)
    {
        $this->id = $id;
        $this->content = $content;
        $this->user_id = $user_id;
        $this->username = $username;
        $this->article_id = $article_id;
        $this->created_at = $created_at ?: date('Y-m-d H:i:s'); 
    }

    public static function find


}