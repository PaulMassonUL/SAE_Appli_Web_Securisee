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
                <label> Email :  <input type="email" name="email" placeholder="email" required> </label></br>
                <label> password :  <input type="password" name="password" placeholder = "<password>" required> </label></br>
                <label> confirm your password :  <input type="password" name="verifpassword" placeholder = "<password>" required> </label></br>
                
                <button type="submit"> Valider </button> 
            </form></br>
            END;
        }
        else
        {  //if ($_SERVER['REQUEST_METHOD'] === 'POST')
            $html = "";

            try
            {
                $email = filter_var($_POST['email'],FILTER_SANITIZE_EMAIL);
                if (isset($_POST['password']) && isset($_POST['verifpassword'])){
                    if ($_POST['password'] !== $_POST['verifpassword']) {
                        throw new AuthException("passwords not match");
                    }
                    $passwd = htmlspecialchars($_POST['password']);
                    $vpasswd = htmlspecialchars($_POST['verifpassword']);
                    Authentification::register($email, $passwd,$vpasswd);
                    $html.=<<<END
                    <b>Inscription is good</b>
                    <a href="?action=signin">Connection</a>
                END;
                }else{
                    $html .= <<<END
                <form method="post" action="?action=add-user">               
                    <label> Email :  <input type="email" name="email" placeholder="email" required> </label></br>
                    <label> password :  <input type="password" name="password" placeholder = "<password>" required> </label></br>
                    <label> confirm your password :  <input type="password" name="verifpassword" placeholder = "<password>" required> </label></br>
                    
                    <button type="submit"> Valider </button> 
                </form>
                <b>Erreur, passwd or vpasswd non defini</b></br>
                END;
                }



            }
            catch(AuthException $e)
            {
                $html .= <<<END
                <form method="post" action="?action=add-user">               
                    <label> Email :  <input type="email" name="email" placeholder="email" required> </label></br>
                    <label> password :  <input type="password" name="password" placeholder = "<password>" required> </label></br>
                    <label> confirm your password :  <input type="password" name="verifpassword" placeholder = "<password>" required> </label></br>
                    
                    <button type="submit"> Valider </button> 
                </form></br>
                <b>{$e->getMessage()}";</b> </br>
                <a href="?action=signin">Connection</a>
                END;
            }
            
            return $html;
        }
    }
}
?>