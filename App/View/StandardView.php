<?php

namespace App\View;

class StandardView
{
    /**
     * @var array $headTemplates List of templates to be included in page head
     * @var array $bodyTemplates List of templates to be included in page body
     * @var array $variables Associative array matching variable names to values
     */
    protected $headTemplates, $bodyTemplates, $variables;

    /**
     * @param array $headTemplates List of templates to be included in page head
     * @param array $bodyTemplates List of templates to be included in page body
     * @param array $variables Associative array matching variable names to values
     */
    public function __construct(array $headTemplates, array $bodyTemplates, array $variables = [])
    {
        $this->headTemplates = $headTemplates;
        $this->bodyTemplates = $bodyTemplates;
        $this->variables = $variables;
    }

    /**
     * Render page as HTML
     */
    public function render()
    {
        // Pour chaque couple de nom de variable/valeur
        foreach ($this->variables as $varName => $value) {
            // Crée une variable qui a pour nom le contenu de $varName
            // et lui assigne la valeur correspondante
            $$varName = $value;
        }

        // Ecrit le contenu de la page
        echo '<!DOCTYPE html>' . PHP_EOL;
        echo '<html lang="fr">' . PHP_EOL;
        echo '<head>' . PHP_EOL;

        // Charge les templates contenus dans le head
        foreach ($this->headTemplates as $template) {
            include './templates/' . $template . '.php';
        }

        echo '</head>' . PHP_EOL;
        echo '<body>' . PHP_EOL;

        // Charge les templates contenus dans le body
        foreach ($this->bodyTemplates as $template) {
            include './templates/' . $template . '.php';
        }

        echo '</body>' . PHP_EOL;
        echo '</html>' . PHP_EOL;
    }
}
