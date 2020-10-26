<?php

namespace App\Controller;

use App\View\StandardView;

class ErrorController
{
    public function notFound()
    {
        return new StandardView(
            [ 'head/meta' ],
            [ 'error/not-found' ]
        );
    }
}
