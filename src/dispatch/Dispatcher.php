<?php

namespace netvod\dispatch;

use netvod\action\ShowCatalogAction;
use netvod\action\ShowFavsAction;

class Dispatcher
{
    protected ?string $action = null;

    public function __construct()
    {
        // action or null
        $this->action = $_GET['action'] ?? null;
    }

    public function run(): void
    {
        switch ($this->action) {
            case 'show-favorites':
                $action = new ShowFavsAction();
                $html = $action->execute();
                break;
            case 'browse':
                $action = new ShowCatalogAction();
                $html = $action->execute();
                break;
            default:
                $html = '
                <a href="?action=show-favorites"><button>Favorite shows</button></a>                
                <a href="?action=browse"><button>Browse catalog</button></a>
                ';

        }

        $this->renderPage($html);
    }

    public function renderPage(string $html): void
    {
        echo <<<END
            <!DOCTYPE html>
            <html lang="fr">
                <head>
                    <title>NetVOD | Accueil</title>
                    <meta charset="utf-8" />
                    <meta name="viewport" content="width=device-width, initial-scale=1.0" /> 
                </head>
                <body>
                    <h1>Sélection du programme</h1>
                    $html
                </body>
            </html> 
            END;
    }
}