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
        return new StandardView(
            [ 'main/home' ]
        );
    }

    /**
     * Access creation features
     */
    public function create(): AbstractView
    {
        return new StandardView(
            [ 'main/create' ],
            [ 'quizzes' => Quiz::findAll() ]
        );
    }
}
