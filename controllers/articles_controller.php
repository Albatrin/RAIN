<?php
/*
    Controller za novice. Vključuje naslednje standardne akcije:
        index: izpiše vse novice
        show: izpiše posamezno novico
        
    TODO:        
       
*/
require_once 'models/comments.php'; // Add this line


class articles_controller
{
    public function index()
    {
        //s pomočjo statične metode modela, dobimo seznam vseh novic
        //$ads bo na voljo v pogledu za vse oglase index.php
        $articles = Article::all();

        //pogled bo oblikoval seznam vseh oglasov v html kodo
        require_once('views/articles/index.php');
    }

    public function show()
    {
        //preverimo, če je uporabnik podal informacijo, o oglasu, ki ga želi pogledati
        if (!isset($_GET['id'])) {
            return call('pages', 'error'); //če ne, kličemo akcijo napaka na kontrolerju stran
            //retun smo nastavil za to, da se izvajanje kode v tej akciji ne nadaljuje
        }
        //drugače najdemo oglas in ga prikažemo
        $article = Article::find($_GET['id']);
        $comments = Comment::find_by_article($article->id); 
        require_once('views/articles/show.php');
    }

    public function store() 
    {
        if (!isset($_SESSION["USER_ID"])) {
            return call('pages', 'error');
        }

        if (!isset($_POST['title']) || !isset($_POST['text']) || !isset($_POST['abstract'])) {
            return call('pages', 'error');
        }

        $db = Db::getInstance();
        $title = mysqli_real_escape_string($db, $_POST['title']);
        $abstract = mysqli_real_escape_string($db, $_POST['abstract']);
        $text = mysqli_real_escape_string($db, $_POST['text']); 
        $user_id = $_SESSION["USER_ID"];

        $query = "INSERT INTO articles (title, abstract, text, user_id) VALUES ('$title', '$abstract', '$text', '$user_id')";

        if ($db->query($query)) {
            header('Location: ?controller=articles&action=index'); 
        } else {
            return call('pages', 'error');
        }
    }

    public function list() 
    {
        if (!isset($_SESSION["USER_ID"])) {
            return call('pages', 'error');
        }
        $db = Db::getInstance();
        $user_id = mysqli_real_escape_string($db, $_SESSION["USER_ID"]);
        $query = "SELECT * FROM articles WHERE user_id = '$user_id'";
        $res = $db->query($query);
        
        $articles = array();
        while ($article = $res->fetch_object()) {
            array_push($articles, new Article($article->id, $article->title, $article->abstract, $article->text, $article->date, $article->user_id));
        }
        
        require_once('views/articles/list.php');
    }

    public function edit() 
    {
        if (!isset($_SESSION["USER_ID"])) {
            return call('pages', 'error');
        }
    
        if (!isset($_GET['id'])) {
            return call('pages', 'error');
        }
    
        $article = Article::find($_GET['id']);
    
        if ($article == null || $article->user->id != $_SESSION["USER_ID"]) {
            return call('pages', 'error');
        }
    
        require_once('views/articles/edit.php');
    }
    

    public function update(){ //UREJANJE

        if (!isset($_SESSION["USER_ID"]) || !isset($_POST['id']) || !isset($_POST['title']) || !isset($_POST['abstract']) || !isset($_POST['content'])) {
            return call('pages', 'error');
        }
       $db = Db::getInstance();
       $title = mysqli_real_escape_string($db, $_POST['title']);
       $abstract = mysqli_real_escape_string($db, $_POST['abstract']);
       $content = mysqli_real_escape_string($db, $_POST['content']);
       $id = $_GET['id'];
       $user_id = $_SESSION['USER_ID'];       
       $query = "UPDATE articles SET title = '$title', abstract = '$abstract', text = '$content' WHERE id = '$id' AND user_id = '$user_id'";


       if ($db->query($query)) {
           header('Location: /articles/index');
       } else {
           return call('pages', 'error');
       }
    }

    public function delete() //Izbirs
    {
        if (!isset($_SESSION["USER_ID"]) || !isset($_GET['id'])) {
            return call('pages', 'error');
        }

        $db = Db::getInstance();
        $id = mysqli_real_escape_string($db, $_GET['id']);
        $user_id = $_SESSION["USER_ID"];
        
        $query = "DELETE FROM articles WHERE id = '$id' AND user_id = '$user_id'";
        
        if ($db->query($query)) {
            header('Location: /articles/list');
        } else {
            return call('pages', 'error');
        }
    }

    public function create(){
        require_once('views/articles/create.php');
    }
}