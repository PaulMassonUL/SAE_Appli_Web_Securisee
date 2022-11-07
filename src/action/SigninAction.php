<?php
namespace netvod\action;

use netvod\auth\Authentification;
use netvod\exception\AuthException;
use \netvod\render\AudioListRenderer;


use netvod\user\User;
use PDO;

class SigninAction extends Action
{
    public function execute() : string
    {
      
        
        if ($this->http_method === 'GET')
        {
            return <<<END
            
            <form method="post" action="?action=signin">
              
                <label> Email :  <input type="email" name="email" placeholder="email"> </label>
                <label> Password :  <input type="password" name="passwd" placeholder = "<mot de passe>"> </label>
                
                <button type="submit"> Valider </button> 
            </form>
            <a href="?action=add-user">inscription</a>
            END;
            
        }
        else // POST
        {
            $html = "";
               try {
                    $email = filter_var($_POST['email'],FILTER_SANITIZE_EMAIL);
                    $email = htmlspecialchars($email);
                    $passwd = htmlspecialchars();
                    $_SESSION['user'] = Authentification::authenticate($email,$passwd);
                    header('Location: accueil.php');

                } catch (AuthException $e) {
                    $html .= "erreur : {$e->getMessage()}";
                } 
            return $html;
            
        }

        
       
        
    }
}


?>