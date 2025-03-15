<?php 
require_once 'model/users.php';

class profile_controller.php{
    public function showProfile(){
        if (!isset($_SESSION("USER_ID"))) {
            header("Location: /login");
            exit();
        }

        $user_id=$_SESSION['USER_ID'];
        $user=User::find($id);
        $arcticleCount=User::countArticles($user_id);
        $commentCount=User::countComments($user_id);
    }
}

