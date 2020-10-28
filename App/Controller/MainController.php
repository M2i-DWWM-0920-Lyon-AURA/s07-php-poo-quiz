<?php

namespace App\Controller;

use App\Model\Quiz;
use App\Core\AbstractView;
use App\View\StandardView;

class MainController
{
    /**
     * Display home page
     */
    public function home(): AbstractView
    {
        // Renvoie une nouvelle vue...
        return new StandardView(
            // ...contenant la page d'accueil
            [ 'main/home' ]
        );
    }

    /**
     * Access creation features
     */
    public function create(): AbstractView
    {
        // Renvoie une nouvelle vue...
        return new StandardView(
            // ...contenant la page de création de quiz...
            [ 'main/create' ],
            // ...ainsi que la liste de tous les quiz
            [ 'quizzes' => Quiz::findAll() ]
        );
    }
}
