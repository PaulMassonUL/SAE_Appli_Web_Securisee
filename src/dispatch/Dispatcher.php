<?php

namespace netvod\dispatch;

use netvod\action\ShowProfileSuccessAction;
use netvod\action\ShowCommentAction;
use netvod\action\ShowProfileAction;
use netvod\action\ShowSerieSucessAction;
use netvod\action\ShowCatalogAction;
use netvod\action\ShowEpisodeAction;
use netvod\action\ShowSerieAction;
use netvod\exception\InvalidPropertyNameException;
use netvod\render\Renderer;
use netvod\render\UserRenderer;

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
        $errorMessage = "<h3 class='error'>Une erreur est survenue à l'affichage de cette page. Retournez à l'accueil.</h3>";
        $user = unserialize($_SESSION['user']);
        switch ($this->action) {
            case 'browse':
                $action = new ShowCatalogAction($user->getCatalogue());
                $html = $action->execute();
                break;
            case 'favorites':
                $action = new ShowCatalogAction($user->getSeriesPref());
                $html = $action->execute();
                break;
            case 'inprogress':
                $action = new ShowCatalogAction($user->getSeriesEnCours());
                $html = $action->execute();
                break;
            case 'show-serie-details':
                if (isset($_POST['serieId'])) {
                    $serieId = intval($_POST['serieId']);
                    $action = new ShowSerieAction($user->getCatalogue()->getSerieById($serieId));
                    $html = $action->execute();
                } else {
                    $this->renderPage($errorMessage);
                    return;
                }
                break;
            case 'add-serie-fav' :
                if (isset($_POST['serieId'])) {
                    $serieId = intval($_POST['serieId']);
                    $serie = $user->getCatalogue()->getSerieById($serieId);
                    $serie->ajouterPreferee($user);
                    $action = new ShowSerieSucessAction($serie, $serie->__get("titre") . " was successfully added to your favorites.");
                    $html = $action->execute();
                } else {
                    $this->renderPage($errorMessage);
                    return;
                }
                break;
            case 'del-serie-fav' :
                if (isset($_POST['serieId'])) {
                    $serieId = intval($_POST['serieId']);
                    $serie = $user->getCatalogue()->getSerieById($serieId);
                    $serie->supprimerPreferee($user);
                    $action = new ShowSerieSucessAction($serie, $serie->__get("titre") . " was successfully removed from your favorites.");
                    $html = $action->execute();
                } else {
                    $this->renderPage($errorMessage);
                    return;
                }
                break;
            case 'add-serie-note' :
                if (isset($_POST['serieId']) && isset($_POST['note'])) {
                    $serieId = intval($_POST['serieId']);
                    $note = floatval($_POST['note']);
                    $serie = $user->getCatalogue()->getSerieById($serieId);
                    $serie->ajouterNote($note);
                    $action = new ShowSerieSucessAction($serie, "You successfully rated " . $serie->__get("titre") . " with $note/5.");
                    $html = $action->execute();
                } else {
                    $this->renderPage($errorMessage);
                    return;
                }
                break;
            case 'add-serie-comment':
                if (isset($_POST['serieId'])) {
                    $serieId = intval($_POST['serieId']);
                    $commentaire = htmlspecialchars($_POST['commentaire']);
                    $serie = $user->getCatalogue()->getSeriebyId($serieId);
                    $serie->ajouterCommentaire($commentaire);
                    $action = new ShowSerieSucessAction($serie, "You successfully comment " . $serie->__get("titre") . " with the comment : $commentaire");
                    $html = $action->execute();
                } else {
                    $this->renderPage($errorMessage);
                    return;
                }
                break;
            case 'show-episode-details':
                if (isset($_POST['serieId']) && isset($_POST['numEpisode'])) {
                    $serieId = intval($_POST['serieId']);
                    $numEpisode = intval($_POST['numEpisode']);
                    $serie = $user->getCatalogue()->getSerieById($serieId);
                    $action = new ShowEpisodeAction($serie->getEpisodeByNum($numEpisode));
                    $html = $action->execute();
                } else {
                    $this->renderPage($errorMessage);
                    return;
                }
                break;
            case 'addMotsCles' :
                if (isset($_POST['choixMotsCles'])) {
                    $cle = $_POST['choixMotsCles'];
//                    $action =
//                    $html = $action->execute();

                } else {
                    $this->renderPage($errorMessage);
                    return;
                }
                break;


            case 'addChoiceTriCatalogue':
                if (isset ($_POST['choixTri'])) {
                    $tri = intval($_POST['choixTri']);
                    $catalog = $user->getCatalogue();
                    $catalog->definirTri($tri);
                    $action = new ShowCatalogAction($catalog);
                    $html = $action->execute();
                } else {
                    $this->renderPage($errorMessage);
                    return;
                }
                break;
            case 'user-profile':
                $action = new ShowProfileAction($user);
                $html = $action->execute();
                break;
            case 'update-profile':
                $user->updateProfile($_POST['nom'], $_POST['prenom'], $_POST['age'], $_POST['genrePref']);
                $action = new ShowProfileSuccessAction("Your profile was successfully updated.");
                $html = $action->execute();
                break;
            case 'show-comments':
                if (isset($_POST['serieId'])) {
                    $serieId = intval($_POST['serieId']);
                    $serie = $user->getCatalogue()->getSerieById($serieId);
                    $commentaires = $serie->getCommentaires();
                    $action = new ShowCommentAction($serie, $commentaires);
                    $html = $action->execute();

                } else {
                    $this->renderPage($errorMessage);
                    return;
                }
                break;
            case 'finished':
                $action = new ShowCatalogAction($user->getSeriesFinies());
                $html = $action->execute();
                break;
            case 'logout':
                session_destroy();
                header('Location: index.php');
                exit();
            default:
                $html = '
                <div id="choice">
                    <h1 id="title"><label>Welcome to NetVOD</label></h1>
                    <h3><label>What are we watching?</label></h3>
                    <div id="action">
                        <a class="button" href="?action=browse"><p>BROWSE CATALOG</p></a>
                        <a class="button" href="?action=favorites"><p>FAVORITE SERIES</p></a>                
                        <a class="button" href="?action=inprogress"><p>SERIES IN PROGRESS</p></a>
                        <a class="button" href="?action=finished"><p>FINISHED SERIES</p></a>                
                    </div>
                </div>
                ';
                break;
        }
        $this->renderPage($html);
    }

    public function renderPage(string $html): void
    {
        $renderer = new UserRenderer(unserialize($_SESSION['user']));
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
                        <a href="?action=finished">Finished</a>
                    </nav>
                    <nav id="">
                        <a href="?action=user-profile" title="Profil">{$renderer->render(Renderer::COMPACT)}</a>
                        <a id="logout" href="?action=logout">
                            <button>LOGOUT</button>
                        </a>
                    </nav>
                </header>
                
                <main id="main">
                    $html
                </main>
            </body>
            </html> 
            END;
    }
}