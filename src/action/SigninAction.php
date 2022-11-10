<?php

namespace netvod\action;

use netvod\auth\Authentification;
use netvod\exception\AuthException;

class SigninAction extends Action
{

    public static function genererReg():string{
        return <<<END
            <h1>Log in</h1>
            <form class="form" method="post" action="?action=signin">
                <div class="labelSin">
                    <label> Email :  <input type="email" name="email" placeholder="email" required> </label></br>
                    <label> Password :  <input type="password" name="password" placeholder = "<password>" required> </label></br>    
                </div>    
                                
                <button type="submit"> Valider </button>
            </form><br>
            
            <a href="">Forgotten password</a>
 END;
    }

    public function execute(): string
    {
        $error = "";
        $html = "";
        if ($this->http_method === 'GET') {
            $html.= SigninAction::genererReg();

        }else{
            $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
            $email = htmlspecialchars($email);
            $passwd = htmlspecialchars($_POST['password']);

            try {
                $_SESSION['user'] = serialize(Authentification::authenticate($email, $passwd));
                header('Location: accueil.php');
                exit();

            } catch (AuthException $e) {
                $html.= SigninAction::genererReg()."<b>{$e->getMessage()}</b>";
            }


        }


    return $html;
    }
}
