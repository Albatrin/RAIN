<?php 
require_once 'models/users.php';

class profile_controller {
    public function showProfile() {
        if (!isset($_SESSION["USER_ID"])) {
            header("Location: /?controller=auth&action=login");
            exit();
        }

        $user_id = $_SESSION['USER_ID'];
        $user = User::find($user_id);
        $articleCount = User::countArticles($user_id);
        $commentCount = User::countComments($user_id);
        
        require_once('views/users/profile.php');    
    }

    public function show() {
        if (!isset($_GET['id'])) {
            header("Location: /pages/error");
            exit();
        }
        
        $user_id = $_GET['id'];
        $user = User::find($user_id);
        
        if (!$user) {
            header("Location: /pages/error");
            exit();
        }
        
        $articleCount = User::countArticles($user_id);
        $commentCount = User::countComments($user_id);
        
        require_once('views/users/profile.php');    
    }
}