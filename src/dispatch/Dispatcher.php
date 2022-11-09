<?php

namespace netvod\dispatch;

use netvod\action\AddSerieFavAction;
use netvod\action\ShowCatalogAction;
use netvod\action\ShowEpisodeAction;
use netvod\action\ShowSerieAction;
use netvod\exception\InvalidPropertyNameException;

class Dispatcher
{
    protected ?string $action = null;

    public function __construct()
    {
        // action or null
        $this->action = $_GET['action'] ?? null;
    }

    /**
     * @throws InvalidPropertyNameException
     */
    public function run(): void
    {
        $html = '
                <div id="choice">
                    <h1 id="title"><label>Welcome to NetVOD</label></h1>
                    <h3><label>What are we watching?</label></h3>
                    <div id="action">
                        <a class="button" href="?action=browse"><p>BROWSE CATALOG</p></a>
                        <a class="button" href="?action=favorites"><p>FAVORITE SERIES</p></a>                
                        <a class="button" href="?action=inprogress"><p>SERIES IN PROGRESS</p></a>                
                    </div>
                </div>
                ';
        switch ($this->action) {
            case 'browse':
                $user = unserialize($_SESSION['user']);
                if (!is_null($user)) {
                    $action = new ShowCatalogAction($user->getCatalogue());
                    $html = $action->execute();
                } else {
                    $html = 'ERROR';
                }
                break;
            case 'favorites':
                $user = unserialize($_SESSION['user']);
                if (!is_null($user)) {
                    $action = new ShowCatalogAction($user->getSeriesPref());
                    $html = $action->execute();
                } else {
                    $html = 'ERROR';
                }
                break;
            case 'inprogress':
                $user = unserialize($_SESSION['user']);
                if (!is_null($user)) {
                    $action = new ShowCatalogAction($user->getSeriesEnCours());
                    $html = $action->execute();
                } else {
                    $html = 'ERROR';
                }
                break;
            case 'show-serie-details':
                $user = unserialize($_SESSION['user']);
                if (!is_null($user) && isset($_POST['serieId'])) {
                    $serieId = intval($_POST['serieId']);
                    $action = new ShowSerieAction($user->getCatalogue()->getSerieById($serieId));
                    $html = $action->execute();
                } else {
                    $html = 'ERROR';
                }
                break;
            case 'show-episode-details':
                $user = unserialize($_SESSION['user']);
                if (!is_null($user) && isset($_POST['serieId']) && isset($_POST['numEpisode'])) {
                    $serieId = intval($_POST['serieId']);
                    $numEpisode = intval($_POST['numEpisode']);
                    $serie = $user->getCatalogue()->getSerieById($serieId);
                    $action = new ShowEpisodeAction($serie->getEpisodeByNum($numEpisode));
                    $html = $action->execute();

                } else {
                    $html = 'ERROR';
                }
                break;
            case 'logout':
                session_destroy();
                header('Location: index.php');
                exit();
            case 'add-serie-fav' :
                $user = unserialize($_SESSION['user']);
                if (! is_null($user) && isset($_POST['serieId2'])) {
                    $serieId = intval($_POST['serieId2']);
                    $serie = $user->getCatalogue()->getSerieById($serieId);
                    $action = new AddSerieFavAction($serie);
                    $html = $action->execute();
                }

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
                        <a href="?action=favorites">Favorite</a>
                        <a href="?action=inprogress">In progress</a>
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