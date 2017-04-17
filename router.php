<?php
session_start();

if (!file_exists(DB_INI_FILE)) {
    header('Location: '.HARDCODED_URL.'errors/error_main.php');
    exit;
}
// Récupération des termes de la route par défaut
$routes = require 'configs/routes.php';
if( isset( $_SESSION['user']->id ) ) {
    $default_route = $routes['index'];
} else{
    $default_route = $routes['formToLog'];
}
$route_parts = explode('/', $default_route);

// Récupération des termes de la route de l’utilisateur
$method = $_SERVER['REQUEST_METHOD'];
$r = $_REQUEST['r']??$route_parts[1];
$a = $_REQUEST['a']??$route_parts[2];

// Vérification que la route demandée est dans la liste des routes de l’app.
if (!in_array($method . '/' . $r . '/' . $a, $routes)) {
    die('Ce que vous cherchez n’est pas ici');
}

// Si la route demandée est dans la liste, on importe le controleur adéquat
$controllerName = 'Controllers\\' . ucfirst($r);
$controller =  new $controllerName();

// Enfin, on exécute la fonction adéquate du controleur chargé
$data = call_user_func([$controller, $a]);
