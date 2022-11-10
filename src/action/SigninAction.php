<?php

namespace netvod\action;

use netvod\auth\Authentification;
use netvod\exception\AuthException;

class SigninAction extends Action
{
    public function execute(): string
    {
        $error = "";

        if ($this->http_method === 'POST') {
            $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
            $email = htmlspecialchars($email);
            $passwd = htmlspecialchars($_POST['password']);

            try {
                $_SESSION['user'] = serialize(Authentification::authenticate($email, $passwd));
                header('Location: accueil.php');
                exit();

            } catch (AuthException $e) {
                $error = "<b>{$e->getMessage()}</b>";
            }

        }else{
            return <<<END
            <h1>Log in</h1>
            <form class="form" method="post" action="?action=signin">
                <div class="labelSin">
                    <label> Email :  <input type="email" name="email" placeholder="email" required> </label></br>
                    <label> Password :  <input type="password" name="password" placeholder = "<mot de passe>" required> </label></br>    
                </div>    
                                
                <button type="submit"> Valider </button>
            </form><br>
            
            <a href="">Forgotten password</a>
             
            $error
        END;
        }



    }
}
