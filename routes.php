<?php
/*
  Usmerjevalnik (router) skrbi za obravnavo HTTP zahtev. Glede na zahtevo, 
  pokliče ustrezno akcijo v zahtevanem controllerju.
*/

// Funkcija, ki kliče kontrolerje in hkrati vključuje njihovo kodo in kodo modela
function call($controller, $action)
{
  // Vključimo kodo controllerja in modela (pazimo na poimenovanje datotek)
  require_once('controllers/' . $controller . '_controller.php');
  if (file_exists('models/' . $controller . '.php')) {
    include_once('models/' . $controller . '.php');
  }

  // Ustvarimo kontroler
  $o = $controller . "_controller"; //generiramo ime razreda controllerja
  $controller = new $o; //ustvarimo instanco razreda (ime razreda je string spremenljivka)

  //pokličemo akcijo na kontrolerju (ime funkcije je string spremenljivka)
  $controller->{$action}();
}

// Seznam vseh dovoljenih controllerjev in njihovih akcij. Z njegovo pomočjo lahko 
// definiramo tudi pravice (ustrezno zmanjšamo nabor akcij pod določenimi pogoji)
$controllers = array(
  'pages' => ['error'],
  'users' => ['create', 'store'],
  'auth' => ['login', 'authenticate'],
  'articles' => ['index', 'show', 'comment'],
  'comments' => ['addComment'],
  'profile' => ['showProfile','show'] 
);

// Če je prijavljen, mu dovolimo še urejanje profila, odjavo in objavo novic
if(isset($_SESSION["USER_ID"])){
  $controllers['users'] = array_merge($controllers['users'], ['edit', 'update','password','update_password']);
  $controllers['auth'] = array_merge($controllers['auth'], ['logout']);
  $controllers['articles'] = array_merge($controllers['articles'], ['create'], ['store'], ['list'], ['update'], ['edit'], ['delete']);
  $controllers['comments'] = array_merge($controllers['comments'], ['addComment']);
  $controllers['profile'] = ['showProfile','show'];
}

// Preverimo, če zahteva kliče controller in akcijo iz zgornjega seznama
if (
  array_key_exists($controller, $controllers)
  && in_array($action, $controllers[$controller])
) {
  // Pokličemo akcijo
  call($controller, $action);
} else {
  // Izpišemo stran z napako
  call('pages', 'error');
}
