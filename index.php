<?php

// Utilise le chargement automatique de Composer
require_once './vendor/autoload.php';

// Crée une nouvelle instance du routeur
$router = new AltoRouter();

// Génère la route pour la page d'accueil
$router->map('GET', '/', 'MainController#home');
// Génère la route pour la liset des quiz
$router->map('GET', '/quiz', 'QuizController#list');
// Prend la requête actuelle et cherche une correspondance avec les routes connues
$match = $router->match();

// Si la requête ne correspond à aucune route connue
if ($match === false) {
    include './templates/page-not-found.php';
} else {
    // Découpe la chaîne de caractère reçue en la séparant au niveau du #
    list($controllerName, $methodName) = explode('#', $match['target']);
    // Crée un contrôleur à partir du nom contenu dans la première portion
    $controllerName = "App\\Controller\\$controllerName";
    $controller = new $controllerName;
    // Appelle la méthode dont le nom est contenu dans la seconde portion
    $controller->$methodName();
}
