<?php
require_once 'models/Comment.php';

class CommentController {
    public function addComment() {
        session_start();
        
        if (!isset($_SESSION['user_id'])) {
            header("Location: /login");
            exit();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $content = $_POST['content'] ?? '';
            $user_id = $_SESSION['user_id'];
            $article_id = $_POST['article_id'] ?? 0;

            if (empty(trim($content))) {
                $_SESSION['error'] = "Comment cannot be empty.";
                header("Location: /articles/view?id=" . $article_id);
                exit();
            }

            // Call the model method
            if (Comment::create($content, $user_id, $article_id)) {
                $_SESSION['success'] = "Comment added successfully!";
            } else {
                $_SESSION['error'] = "Error adding comment.";
            }

            header("Location: /articles/view?id=" . $article_id);
            exit();
        }
    }
}
?>
