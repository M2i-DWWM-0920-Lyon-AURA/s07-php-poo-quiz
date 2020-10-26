<?php

// Utilise le chargement automatique de Composer
require_once './vendor/autoload.php';

// Crée une nouvelle instance du routeur
$router = new AltoRouter();

// Génère la route pour la page d'accueil
$router->map('GET', '/', 'home.php');
// Génère la route pour la liset des quiz
$router->map('GET', '/quiz', 'quiz-list.php');
// Prend la requête actuelle et cherche une correspondance avec les routes connues
$match = $router->match();

// Si la requête ne correspond à aucune route connue
if ($match === false) {
    include './templates/page-not-found.php';
} else {
    include './templates/' . $match['target'];
}
