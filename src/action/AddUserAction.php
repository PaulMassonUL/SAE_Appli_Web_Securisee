<?php

namespace netvod\action;

use netvod\auth\Authentification;
use netvod\exception\AuthException;

class AddUserAction extends Action
{

    public static function genererReg(): string
    {
        return <<<END
                <h1>Register</h1>
                <form class="form" method="post" action="?action=add-user">                
                    <label> Email :  <input type="email" name="email" placeholder="email" required> </label></br>
                    <label> password :  <input type="password" name="password" placeholder = "<password>" required> </label></br>
                    <label> confirm your password :  <input type="password" name="verifpassword" placeholder = "<password>" required> </label></br>
                    
                    <button type="submit"> Valider </button> 
                </form></br>
            END;
    }


    /**
     * @return string
     * fonction sign up
     */
    public function execute(): string
    {
        $error = "";
        $html = "";
        if ($this->http_method === 'GET') {
            $html = AddUserAction::genererReg();

        } else {
            $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
            $email = htmlspecialchars($email);
            $passwd = htmlspecialchars($_POST['password']);

            try {
                if ($_POST['password'] !== $_POST['verifpassword']) {
                    throw new AuthException("passwords are not the same");
                }
                $url = Authentification::register($email, $passwd);
                $html .= <<<END
                    <b>Signed up !</br>Now you need to activate your account,</br>please click <a href="$url">here</a>.</b>
                END;

            } catch (AuthException $e) {

                $html .= AddUserAction::genererReg() . "<b>{$e->getMessage()}</b>";
            }

        }

        return $html;
    }
}

?>