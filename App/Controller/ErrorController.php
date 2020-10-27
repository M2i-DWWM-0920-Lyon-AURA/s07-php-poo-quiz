<?php

namespace App\Controller;

use App\View\StandardView;

class ErrorController
{
    /**
     * Display a "page not found" page
     */
    public function notFound()
    {
        // Remplace le code de réponse par défaut (200: OK) par une code d'erreur (404: Not Found)
        // afin de signifier au client que la requête s'est terminée en erreur
        \http_response_code(404);

        return new StandardView(
            [ 'error/not-found' ]
        );
    }
}
