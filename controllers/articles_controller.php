<?php
/*
    Controller za novice. Vključuje naslednje standardne akcije:
        index: izpiše vse novice
        show: izpiše posamezno novico
        
    TODO:
        list: izpiše novice prijavljenega uporabnika
        create: izpiše obrazec za vstavljanje novice
        store: vstavi novico v bazo
        edit: izpiše vmesnik za urejanje novice
        update: posodobi novico v bazi
        delete: izbriše novico iz baze
*/

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
        require_once('views/articles/show.php');
    }

    public function create(){
        require_once('views/articles/create.php');
    }

    public function store() {
        // Check if user is logged in
        session_start();
        if (!isset($_SESSION['user_id'])) {
            return call('pages', 'error');
        }

        // Validate input
        if (!isset($_POST['title']) || !isset($_POST['abstract']) || !isset($_POST['text'])) {
            return call('pages', 'error');
        }

        // Get data from form
        $title = $_POST['title'];
        $abstract = $_POST['abstract'];
        $text = $_POST['text'];
        $user_id = $_SESSION['user_id'];

        // Create new article
        if (Article::insert($title, $abstract, $text, $user_id)) {
            header('Location: ?controller=articles&action=index');
        } else {
            return call('pages', 'error');
        }
    }
}