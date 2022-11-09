<?php

namespace netvod\action;

use netvod\auth\Authentification;
use netvod\exception\AuthException;

use netvod\user\User;

class SigninAction extends Action
{
    public function execute(): string
    {


        if ($this->http_method === 'GET') {
            return <<<END
            
            <form id="Formsignin" method="post" action="?action=signin">
              
                <label> Email :  <input type="email" name="email" placeholder="email"> </label></br>
                <label> Password :  <input type="password" name="passwd" placeholder = "<mot de passe>"> </label></br>
                
                <button type="submit"> Valider </button>
            </form><br>
            END;

        } else // POST
        {
            $html = "";
            try {
                $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
                $email = htmlspecialchars($email);
                $passwd = htmlspecialchars($_POST['passwd']);

                $_SESSION['user'] = serialize(Authentification::authenticate($email, $passwd));
                header('Location: accueil.php');

            } catch (AuthException $e) {
                $html .= <<<END
                        <form method="post" action="?action=signin">
                          
                            <label> Email :  <input type="email" name="email" placeholder="email"> </label></br>
                            <label> Password :  <input type="password" name="passwd" placeholder = "<mot de passe>"> </label></br>
                            
                            <button type="submit"> Valider </button> 
                        </form>
                        <b>{$e->getMessage()}</b></br>
                        END;
            }
            return $html;

        }


    }
}
