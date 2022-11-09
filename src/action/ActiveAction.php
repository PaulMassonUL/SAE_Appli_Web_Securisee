<?php

namespace netvod\action;
use \netvod\db\ConnectionFactory;

class ActiveAction{

    public static function creationActivationToken(string $email):string{
        $token = bin2hex(random_bytes(32));
        $url_act = "http://{$_SERVER['HTTP_HOST']}/Mesfichier/SAE_Appli_Web_Securisee/?action=active+token=$token";
        var_dump($token);
        $db = ConnectionFactory::makeConnection();
        $expiration_time =time() + 60*60*24;
        $query ="update users set activation_token=?,activation_expires=FROM_UNIXTIME(?) where email=?";
        $stmt = $db->prepare($query);
        $stmt->bindParam(1,$token);
        $stmt->bindParam(2,$expiration_time);
        $stmt->bindParam(3,$email);
        $stmt->execute();
        return $url_act;
    }

    public function execute(): string
    {
        $html = "";

        $db = ConnectionFactory::makeConnection();
        $query = "select * from users where activation_token={$_GET['token']}";
        $stmt = $db->prepare($query);
        $stmt->execute();
        $res = $stmt->fetch()[0];
        $email = $res[0];
        $valid_token = $res[4];
        if (date('Y-m-d H:i:s',time() ) > $valid_token){
            $url_act = ActiveAction::creationActivationToken($email);
            $html.= <<<END
            <b>token is not valid, here is a new link to activate your account </b>
            <b>link : $url_act</b>
            END;
        }else{
            $query ="update User set active = 1, activation_token=null where activation_token = {$_GET['token']}";
            $stmt = $db->prepare($query);
            $stmt->execute();

            $html.= <<<END
            <b>Your account has been validate, you can now connect :</b>
            <a href="?action=add-user">Sign in</a>
            END;


        }

        return $html;
    }
}