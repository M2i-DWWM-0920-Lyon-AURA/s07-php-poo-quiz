<?php

namespace App\Controller;

use App\View\StandardView;

class MainController
{
    /**
     * Display home page
     */
    public function home()
    {
        $view = new StandardView(
            [ 'head/meta' ],
            [ 'main/home' ]
        );
        $view->render();
    }
}
