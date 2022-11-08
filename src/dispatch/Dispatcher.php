<?php

namespace netvod\dispatch;

use netvod\action\ShowCatalogAction;
use netvod\action\ShowSerieAction;
use netvod\user\User;

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
        $html = '
                <h1>Choix du programme</h1>
                <a href="?action=show-favorites"><button>Favorite shows</button></a>                
                <a href="?action=browse"><button>Browse catalog</button></a>
                ';
        switch ($this->action) {
            case 'show-favorites':
                $user = User::getInstance();
                if (!is_null($user)) {
                    $action = new ShowCatalogAction($user->getSeriesPref());
                    $html = $action->execute();
                }
                break;
            case 'browse':
                $user = User::getInstance();
                if (!is_null($user)) {
                    $action = new ShowCatalogAction($user->getCatalogue());
                    $html = $action->execute();
                }
                break;
            case 'show-serie-details':
                $user = User::getInstance();
                if (!is_null($user)) {
                    if (isset($_POST['serieId'])) {
                        $serieId = intval($_POST['serieId']);
                        $action = new ShowSerieAction($user->getCatalogue()->getSerieById($serieId));
                        $html = $action->execute();
                    }
                }
                break;
            case 'show-episode-details':
                $user = User::getInstance();
                if (!is_null($user)) {
                    if (isset($_POST['serieId']) && isset($_POST['numEpisode'])) {
                        $serieId = intval($_POST['serieId']);
                        $numEpisode = intval($_POST['numEpisode']);
                        $serie = $user->getCatalogue()->getSerieById($serieId);
                        if (!is_null($serie)) {
                            $action = new ShowEpisodeAction($serie->getEpisodeByNum($numEpisode));
                            $html = $action->execute();
                        }
                    }
                }
                break;
            case 'logout':
                session_destroy();
                header('Location: index.php');
                exit();

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
                    $html
                </body>
            </html> 
            END;
    }
}