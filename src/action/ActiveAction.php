<?php

namespace netvod\action;
use \netvod\db\ConnectionFactory;

class ActiveAction{

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
            $token = bin2hex(random_bytes(32));
            $query = "update users set activation_token=$token and activation_expires=time() + 60*60*24";
            $stmt = $db->prepare($query);
            $stmt->execute();
            $url_act = "http://{$_SERVER['HTTP_HOST']}index.php?action=active+token=$token";
            $html= <<<END
            <b>token is not valid, here is a new link to activate your account </b>
            <b>link : $url_act</b>
            END;
        }else{
            $query ="update User set active = 1, renew_token=null where renew_token = {$_GET['token']}";
            $stmt = $db->prepare($query);
            $stmt->execute();

            $html= <<<END
            <b>Your account has been validate, you can now connect :</b>
            <a href="?action=add-user"></a>
            END;


        }
    }
}