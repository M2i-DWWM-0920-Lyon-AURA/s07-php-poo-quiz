<?php

use App\View\StandardView;
use App\Controller\ErrorController;
use App\Exception\RecordNotFoundException;

// Utilise le chargement automatique de Composer
require_once './vendor/autoload.php';

// Essaie d'exécuter le programme normalement
try {
    // Crée une nouvelle instance du routeur
    $router = new AltoRouter();

    // Génère la route pour la page d'accueil
    $router->map('GET', '/', 'MainController#home');
    // Génère la route pour la liste des quiz
    $router->map('GET', '/quiz', 'QuizController#list');
    // Génère la route pour la liste des quiz
    $router->map('GET', '/quiz/[i:id]', 'QuizController#single');
    // Prend la requête actuelle et cherche une correspondance avec les routes connues
    $match = $router->match();

    // Si la requête ne correspond à aucune route connue
    if ($match === false) {
        $controller = new ErrorController;
        $response = $controller->notFound();
    } else {
        // Extrait toutes les valeurs des paramètres présents dans l'URL
        $params = array_values($match['params']);
        // Découpe la chaîne de caractère reçue en la séparant au niveau du #
        list($controllerName, $methodName) = explode('#', $match['target']);
        // Crée un contrôleur à partir du nom contenu dans la première portion
        $controllerName = "App\\Controller\\$controllerName";
        $controller = new $controllerName;
        // Appelle la méthode dont le nom est contenu dans la seconde portion
        // en lui passant l'ensemble des paramètres récupérés dans l'URL
        $response = $controller->$methodName(...$params);
    }
}
// Si une erreur liée à un enregistrement non existant en BDD est détectée
catch (RecordNotFoundException $exception) {
    $controller = new ErrorController;
    $response = $controller->notFound();
}

$response->render();
die();
