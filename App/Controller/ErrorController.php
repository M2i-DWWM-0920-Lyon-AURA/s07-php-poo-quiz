<?php

namespace App\Controller;

use App\View\StandardView;

class ErrorController
{
    public function notFound()
    {
        $view = new StandardView(
            [ 'head/meta' ],
            [ 'error/not-found' ]
        );
        $view->render();
    }
}
