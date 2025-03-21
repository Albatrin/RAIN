<?php
/*
    Controller za uporabnike. Vključuje naslednje standardne akcije:
        create: izpiše obrazec za registracijo
        store: obdela podatke iz obrazca za registracijo in ustvari uporabnika v bazi
        edit: izpiše obrazec za urejanje profila
        update: obdela podatke iz obrazca za urejanje profila in jih shrani v bazo
*/

class users_controller
{
    function create(){
        $error = "";
        if(isset($_GET["error"])){
            switch($_GET["error"]){
                case 1: $error = "Izpolnite vse podatke"; break;
                case 2: $error = "Gesli se ne ujemata."; break;
                case 3: $error = "Uporabniško ime je že zasedeno."; break;
                default: $error = "Prišlo je do napake med registracijo uporabnika.";
            }
        }
        require_once('views/users/create.php');
    }
    
    function store(){
        if(empty($_POST["username"]) || empty($_POST["email"]) || empty($_POST["password"])){
            header("Location: /users/create?error=1"); 
        }
        else if($_POST["password"] != $_POST["repeat_password"]){
            header("Location: /users/create?error=2"); 
        }
        // ali uporabniško ime obstaja
        else if(User::is_available($_POST["username"])){
            header("Location: /users/create?error=3"); 
        }
        else if(User::create($_POST["username"], $_POST["email"], $_POST["password"])){
            header("Location: /auth/login");
        }
       
        else{
            header("Location: /users/create?error=4"); 
        }
        die();
    }

    function edit(){
        if(!isset($_SESSION["USER_ID"])){
            header("Location: /pages/error");
            die();
        }
        $user = User::find($_SESSION["USER_ID"]);
        $error = "";
        if(isset($_GET["error"])){
            switch($_GET["error"]){
                case 1: $error = "Izpolnite vse podatke"; break;
                case 2: $error = "Uporabniško ime je že zasedeno."; break;
                default: $error = "Prišlo je do napake med urejanjem uporabnika.";
            }
        }
        require_once('views/users/edit.php');
    }

    function update(){
        if(!isset($_SESSION["USER_ID"])){
            header("Location: /pages/error");
            die();
        }
        $user = User::find($_SESSION["USER_ID"]);
        //Preveri če so vsi podatki izpolnjeni
        if(empty($_POST["username"]) || empty($_POST["email"])){
            header("Location: /users/edit?error=1"); 
        }
        //Preveri ali uporabniško ime obstaja
        else if($user->username != $_POST["username"] && User::is_available($_POST["username"])){
            header("Location: /users/edit?error=2"); 
        }
        //Podatki so pravilno izpolnjeni, registriraj uporabnika
        else if($user->update($_POST["username"], $_POST["email"])){
            header("Location: /");
        }
        //Prišlo je do napake pri registraciji
        else{
            header("Location: /users/edit?error=3"); 
        }
        die();
    }

    function password(){
        if (!isset($_SESSION["USER_ID"])) {
           return call('pages', 'error'); 
       }
   
       $error = "";
       $success = "";
       
       if(isset($_GET["error"])){
           switch($_GET["error"]){
               case 1: $error = "Izpolnite vse podatke"; break;
               case 2: $error = "Staro geslo ni pravilno."; break;
               case 3: $error = "Novi gesli se ne ujemata."; break;
               case 4: $error = "Prišlo je do napake pri posodobitvi gesla."; break;
               default: $error = "Prišlo je do napake.";
           }
       }
       
       if(isset($_GET["success"])){
           $success = "Geslo je bilo uspešno posodobljeno!";
       }
   
       require_once('views/users/password.php');
   }

   function update_password() {
    if(!isset($_SESSION["USER_ID"])){
        header("Location: /pages/error");
        die();
    }

    if(empty($_POST["old_password"]) || empty($_POST["new_password"]) || empty($_POST["confirm_password"])){
        header("Location: /users/password?error=1");
        die();
    }

    $user = User::find($_SESSION["USER_ID"]);
    
    if(!password_verify($_POST["old_password"], $user->password)){
        header("Location: /users/password?error=2");
        die();
    }

    if($_POST["new_password"] !== $_POST["confirm_password"]){
        header("Location: /users/password?error=3");
        die();
    }

    $db = Db::getInstance();
    $id = $_SESSION["USER_ID"];
    
    $query = "UPDATE users SET password = '$new_password' WHERE id = $id LIMIT 1";
    
    if($db->query($query)){
        header("Location: /users/password?success=1"); 
    } else {
        header("Location: /users/password?error=4");
    }
    die();
}
}