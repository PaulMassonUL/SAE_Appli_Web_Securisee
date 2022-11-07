<?php

namespace netvod\action;

use netvod\auth\Authentifivation as Auth ;

class AddUserAction extends Action
{
    public function execute() : string
    {
        if ($this->http_method === 'GET')
        {
            return <<<END
            <form method="post" action="?action=add-user">                
                <label> Email :  <input type="email" name="email" placeholder="email"> </label></br>
                <label> password :  <input type="password" name="password" placeholder = "<password>"> </label>
                <label> rentrer une seconde fois votre password :  <input type="password" name="password" placeholder = "<password>"> </label>
                
                <button type="submit"> Valider </button> 
            </form>
            <a href="?action=signin">Inscription</a>
            END;
        }
        else
        {  //if ($_SERVER['REQUEST_METHOD'] === 'POST')
            $html = "";
            try
            {
                if (Auth::register($_POST['email'], $_POST['password'])){
                    $html .= "<b> compte crée avec succes vous pouvez vous connecter </b>";
                }

                

            }
            catch(\iutnc\deefy\auth\AuthException $e)
            {
                $html .= "<h4> erreur de création de compte : {$e->getMessage()}";
            }
            
            return $html;
        }
    }
}
?>