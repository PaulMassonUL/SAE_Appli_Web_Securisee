<?php

namespace netvod\dispatch;

use netvod\action\ActiveAction;
use netvod\action\AddUserAction;
use  netvod\action\SigninAction;

class Dispatcher_Auth
{
    protected ?string $action = null;

    public function __construct()
    {
        $this->action = $_GET['action'] ?? null;
    }

    public function run(): void
    {
        switch ($this->action) {
            case 'add-user':
                $act = new AddUserAction();
                break;
            case 'active':
                $act = new ActiveAction();
                break;
            default:
                $act = new SigninAction();
                break;

        }
        $html = $act->execute();
        $this->renderPage($html);

    }

    private function renderPage(string $html): void
    {
        echo <<<END
        <!DOCTYPE html>
        <html lang="fr">
            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <link rel="stylesheet" href="css/typeIndex.css">
                <title>Deefy</title>
            </head>
            <body>
                <header id="header">
                    <nav id="nav">
                        <a id="title" href="index.php">NetVOD</a>
                        <a href="?action=signin">signin</a>
                        <a href="?action=add-user">signup</a>                       
                    </nav>
                </header>    
                <div class="signin">
                    
                    $html
                </div><br>
            </body>
        </html>
        END;
    }
}
