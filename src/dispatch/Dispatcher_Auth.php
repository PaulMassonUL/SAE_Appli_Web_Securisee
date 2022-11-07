<?php
namespace netvod\dispatch;

use \iutnc\deefy\action\DisplayPlaylistAction as DisplayPlaylistAction;
use \iutnc\deefy\action\AddUserAction as AddUserAction;
use \iutnc\deefy\action\SigninAction as SigninAction;
use \iutnc\deefy\action\AddPodcastTrackAction as AddPodcastTrackAction;

class Dispatcher
{
    protected ?string $action = null;

    public function __construct()
    {
        $this->action = isset($_GET['action']) ? $_GET['action'] : null;
    }

    public function run() : void
    {
        switch ($this->action) {
            case 'add-user':
                $act = new AddUserAction();
                $html = $act->execute();
                break;
            case 'signin':
                $act = new SigninAction();
                $html = $act->execute();
                break;
            default:
                $html = '<ul>
                            <li><a href="?action=signin">Connexion</a></li>
                            <li><a href="?action=add-user">Inscription</a></li>
                        </ul>';
                break;
            
        }
        $this->renderPage($html);
        
    }

    private function renderPage(string $html) : void
    {
        echo <<<END
        <!DOCTYPE html>
        <html lang="fr">
            <head>
                <meta charset="UTF-8">>
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>Deefy</title>
            </head>
            <body>
                <h1>Bienvenue sur la platforme NetVOD</h1>
                <nav>
                    $html
                </nav><br>
            </body>
        </html>
        END;
    }
}
?>