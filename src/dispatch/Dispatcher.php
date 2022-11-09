<?php

namespace netvod\dispatch;

use netvod\action\ShowCatalogAction;
use netvod\action\ShowEpisodeAction;
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
                <div id="choice">
                    <h1 id="title"><label>Welcome to NetVOD</label></h1>
                    <h3><label>What are we watching?</label></h3>
                    <div id="action">
                        <a class="button" href="?action=browse"><p>BROWSE CATALOG</p></a>
                        <a class="button" href="?action=show-favorites"><p>FAVORITE SERIES</p></a>                
                    </div>
                </div>
                ';
        switch ($this->action) {
            case 'show-favorites':
                $user = unserialize($_SESSION['user']);
                if (!is_null($user)) {
                    $action = new ShowCatalogAction($user->getSeriesPref());
                    $html = $action->execute();
                }
                break;
            case 'browse':
                $user = unserialize($_SESSION['user']);
                if (!is_null($user)) {
                    $action = new ShowCatalogAction($user->getCatalogue());
                    $html = $action->execute();
                }
                break;
            case 'show-serie-details':
                $user = unserialize($_SESSION['user']);
                if (!is_null($user)) {
                    if (isset($_POST['serieId'])) {
                        $serieId = intval($_POST['serieId']);
                        $action = new ShowSerieAction($user->getCatalogue()->getSerieById($serieId));
                        $html = $action->execute();
                    }
                }
                break;
            case 'show-episode-details':
                $user = unserialize($_SESSION['user']);
                if (!is_null($user) && isset($_POST['serieId']) && isset($_POST['numEpisode'])) {
                    $serieId = intval($_POST['serieId']);
                    $numEpisode = intval($_POST['numEpisode']);
                    $serie = $user->getCatalogue()->getSerieById($serieId);
                    $action = new ShowEpisodeAction($serie, $serie->getEpisodeByNum($numEpisode));
                    $html = $action->execute();

                } else {
                    $html = 'ERROR';
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
                <title>NetVOD | Series on demand</title>
                <meta charset="utf-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0" />
                <link rel="stylesheet" href="css/style.css">
            </head>
            <body>
                <header id="header">
                    <nav id="nav">
                        <a id="title" href="accueil.php">NetVOD</a>
                        <a href="?action=browse">Series</a>
                        <a href="?action=show-favorites">Favorite</a>
                    </nav>
                    <a id="logout" href="?action=logout">
                        <button>LOGOUT</button>
                    </a>
                </header>
                
                <main id="main">
                    $html
                </main>
            </body>
            </html> 
            END;
    }
}