<?php
namespace netvod\action;

use netvod\auth\Authentification;
use netvod\dispatch\Dispatcher;
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
              
                <label> Email :  <input type="email" name="email" placeholder="email"> </label></br>
                <label> Password :  <input type="password" name="passwd" placeholder = "<mot de passe>"> </label></br>
                
                <button type="submit"> Valider </button>
            </form><br>
            <a href="?action=add-user">inscription</a>
            END;
            
        }
        else // POST
        {
            $html = "";
               try {
                    $email = filter_var($_POST['email'],FILTER_SANITIZE_EMAIL);
                    $email = htmlspecialchars($email);
                    $passwd = htmlspecialchars($_POST['passwd']);
                    $_SESSION['user'] = serialize(Authentification::authenticate($email,$passwd));
                    $dis = new Dispatcher();
                    $dis->run();
                    //header('Location: accueil.php');

               } catch (AuthException $e) {
                    $html .= <<<END
                        <form method="post" action="?action=signin">
                          
                            <label> Email :  <input type="email" name="email" placeholder="email"> </label></br>
                            <label> Password :  <input type="password" name="passwd" placeholder = "<mot de passe>"> </label></br>
                            
                            <button type="submit"> Valider </button> 
                        </form>
                        <b>{$e->getMessage()}</b></br>
                        <a href="?action=add-user">inscription</a>
                        END;
               }
            return $html;
            
        }

        
       
        
    }
}


?>