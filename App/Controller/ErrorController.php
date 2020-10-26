<?php

namespace App\Controller;

use App\View\StandardView;

class ErrorController
{
    public function notFound()
    {
        \http_response_code(404);

        return new StandardView(
            [ 'head/meta' ],
            [ 'error/not-found' ]
        );
    }
}
