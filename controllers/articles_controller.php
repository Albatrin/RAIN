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
    $text = mysqli_real_escape_string($db, $_POST['text']); // Spremenjeno iz content v text
    $user_id = $_SESSION["USER_ID"];

    $query = "INSERT INTO articles (title, abstract, text, user_id) VALUES ('$title', '$abstract', '$text', '$user_id')";

    if ($db->query($query)) {
        header('Location: ?controller=articles&action=index'); // Popravljena pot
    } else {
        return call('pages', 'error');
    }
}


    public function create(){
        require_once('views/articles/create.php');
    }
}