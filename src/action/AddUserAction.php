<?php

namespace netvod\action;

use netvod\auth\Authentification;
use netvod\exception\AuthException;

class AddUserAction extends Action
{
    public function execute() : string
    {
        if ($this->http_method === 'GET')
        {
            return <<<END
            <form method="post" action="?action=add-user">                
                <label> Email :  <input type="email" name="email" placeholder="email"> </label></br>
                <label> password :  <input type="password" name="password" placeholder = "<password>"> </label></br>
                <label> rentrer une seconde fois votre password :  <input type="password" name="verifpassword" placeholder = "<password>"> </label>
                
                <button type="submit"> Valider </button> 
            </form>
            <a href="?action=signin">Connection</a>
            END;
        }
        else
        {  //if ($_SERVER['REQUEST_METHOD'] === 'POST')
            $html = "";

            try
            {
                $email = filter_var($_POST['email'],FILTER_SANITIZE_EMAIL);
                $passwd = htmlspecialchars($_POST['password']);
                Authentification::register($email, $passwd,$_POST['verifpassword']);
                $html.=<<<END
                    <b>Inscription is good</b>
                    <a href="?action=signin">Connection</a>
                END;

            }
            catch(AuthException $e)
            {
                $html .= <<<END
                <form method="post" action="?action=add-user">               
                    <label> Email :  <input type="email" name="email" placeholder="email"> </label></br>
                    <label> password :  <input type="password" name="password" placeholder = "<password>"> </label>
                    <label> rentrer une seconde fois votre password :  <input type="password" name="password" placeholder = "<password>"> </label>
                    
                    <button type="submit"> Valider </button> 
                </form>
                <b>erreur de création de compte : {$e->getMessage()}";</b> 
                <a href="?action=signin">Connection</a>
                END;
            }
            
            return $html;
        }
    }
}
?>