<?php
namespace netvod\action;

use \iutnc\deefy\auth\Auth as Auth;
use \iutnc\deefy\auth\User as User;

use \iutnc\deefy\render\AudioListRenderer;


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
                <label> Passwd :  <input type="password" name="passwd" placeholder = "<mot de passe>"> </label>
                
                <button type="submit"> Valider </button> 
            </form>
            END;
            
        }
        else // POST
        {
            $html = "";
               try {
                    
                    $email = htmlspecialchars($_POST['email']);
                    $passwd = htmlspecialchars($_POST['passwd']);
                    Auth::authenticate($email, $passwd);
                    $html .= "<h2> connexion réussie </h2>";
                    $user1 = new User($email, $passwd, 1);
                    $_SESSION['user'] = $user1;
                    //echo $user1->getPlaylists();
                    
                    foreach ($user1->getPlaylists() as $pl) {
                        /*$rend = new AudioListRenderer($pl);
                        $html .= $rend->render(1); */
                        $html .= $pl->id . " - ". $pl->nom. "<br />";
                    }
                    //$html .= implode(",", $user1->getPlaylists());
                } catch (\iutnc\deefy\AuthException\AuthException $e) {
                    $html .= "erreur : {$e->getMessage()}";
                } 
            return $html;
            /*$html = "";
            $email = htmlspecialchars($_POST["email"]);
            $passwd = htmlspecialchars($_POST["passwd"]);
            $aVerif = Auth::authenticate($email, $passwd);
            if (!is_null($aVerif))
            {
                $user = new User($email, $passwd);
                $html .= strval($user->getPlaylists()); // $html .=
                //$html .= "hey";
            }
            return $html; */
            
        }

        
       
        
    }
}


?>