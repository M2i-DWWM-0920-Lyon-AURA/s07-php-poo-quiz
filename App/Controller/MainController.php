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
        return new StandardView(
            [ 'head/meta' ],
            [ 'main/home' ]
        );
    }
}
