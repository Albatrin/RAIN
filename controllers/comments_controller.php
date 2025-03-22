<?php
require_once 'models/comments.php';

class comments_controller {
    public function addComment() {
        if (!isset($_SESSION['USER_ID'])) {
            header("Location: /auth/login");
            exit();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $content = $_POST['content'] ?? '';
            $user_id = $_SESSION['USER_ID'];
            $article_id = $_POST['article_id'] ?? 0;

            if (empty(trim($content))) {
                $_SESSION['error'] = "Komentar ne more biti prazen.";
                header("Location: /articles/show?id=" . $article_id);
                exit();
            }

            // Call the model method
            if (Comment::create($content, $user_id, $article_id)) {
                $_SESSION['success'] = "Komentar uspešno dodan!";
            } else {
                $_SESSION['error'] = "Napaka pri dodajanju komentarja.";
            }

            header("Location: /articles/show?id=" . $article_id);
            exit();
        }
    }
}
?>