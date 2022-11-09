<?php

namespace netvod\action;

use netvod\auth\Authentification;
use netvod\dispatch\Dispatcher;
use netvod\exception\AuthException;

use netvod\user\User;

class SigninAction extends Action
{
    public function execute(): string
    {


        if ($this->http_method === 'GET') {
            return <<<END
            
            <form class="form" method="post" action="?action=signin">
                <div class="labelSin">
                    <label class="Lemail"> Email :  <input type="Iemail" name="email" placeholder="email"> </label></br>
                    <label class="Lpasswd"> Password :  <input type="Ipassword" name="passwd" placeholder = "<mot de passe>"> </label></br>    
                </div>    
                
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

                User::setInstance(Authentification::authenticate($email, $passwd));
                $dis = new Dispatcher();
                $dis->run();
                header('Location: accueil.php');
                exit();

            } catch (AuthException $e) {
                $html .= <<<END
                        <form  method="post" action="?action=signin">
                            <div class="form">
                              <label class="Lemail"> Email :  <input type="Iemail" name="email" placeholder="email"> </label></br>
                              <label class="passwd"> Password :  <input type="password" name="passwd" placeholder = "<mot de passe>"> </label></br>    
                            </div>    
                            <button class="bSin" type="submit"> Valider </button> 
                        </form>
                        <b>{$e->getMessage()}</b></br>
                        END;
            }
            return $html;

        }


    }
}
