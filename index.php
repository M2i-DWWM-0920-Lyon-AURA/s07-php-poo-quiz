<?php
// ================================================================
// Front controller
// ----------------------------------------------------------------
// ~ Toutes les requêtes au serveur sont redirigées sur ce fichier
// grâce au fichier .htaccess.
// ~ Le Front controller a pour mission d'intercepter toutes les
// requêtes et d'envoyer l'utilisateur à l'endroit adéquat de
// l'application.
// ================================================================

// Utilise le chargement automatique de Composer
require_once './vendor/autoload.php';

use App\View\StandardView;
use App\Controller\ErrorController;
use App\Exception\RecordNotFoundException;

// ================================================================
// Gestion des erreurs
// ----------------------------------------------------------------
// ~ On peut emballer une série d'instructions dans un bloc "try"
// (essayer), et ajouter à la suite un bloc "catch" (attraper). Si
// une erreur est détectée dans le bloc "try", PHP passe aussitôt
// dans le bloc "catch" au lieu de s'arrêter à l'erreur.
// ~ Ceci nous permet de renvoyer l'utilisateur, par exemple à une
// page d'erreur 404, en générant des erreurs personnalisées aux
// endroits adéquats de notre code.
// ================================================================

// Essaie d'exécuter le programme normalement
try {
    // ================================================================
    // Routeur
    // ----------------------------------------------------------------
    // ~ Chaque requête contient une méthode (GET, POST...) et une URL.
    // Chaque combinaison de méthode/URL prévue dans une application
    // s'appelle une "route". Le routeur est un composant chargé de
    // trouver une correspondance entre la requête de l'utilisateur et
    // l'une des routes de l'application.
    // ~ On fait correspondre à chaque route un nom de contrôleur et
    // une méthode. Ainsi, on a la liberté de faire correspondre
    // n'importe quel comportement à chaque route.
    // ================================================================

    // Crée une nouvelle instance du routeur
    $router = new AltoRouter();

    // Configure le routeur avec toutes les routes de l'application
    $router->map('GET', '/', 'MainController#home');
    $router->map('GET', '/quiz', 'QuizController#list');
    $router->map('GET', '/quiz/[i:id]', 'QuizController#single');
    $router->map('GET', '/question/[i:id]', 'QuestionController#single');
    $router->map('POST', '/question/[i:id]/give-answer', 'QuestionController#processAnswer');
    // Prend la requête actuelle et cherche une correspondance avec les routes connues
    $match = $router->match();

    // Si la requête ne correspond à aucune route connue
    if ($match === false) {
        // Renvoie une page "Page non trouvée"
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
    // Renvoie une page "Page non trouvée"
    $controller = new ErrorController;
    $response = $controller->notFound();
}

// Une fois que le contrôleur approprié a été appelé, affiche le résultat
$response->render();
// Interrompt le programme
die();
