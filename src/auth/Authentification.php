<?php
namespace netvod\auth;

use netvod\action\ActiveAction;
use netvod\user\User;
use PDO;
use netvod\db\ConnectionFactory as ConnectionFactory;
use netvod\exception\AuthException as AuthException;
use PDOException;

class Authentification
{

    // controler la solidité des mots de passe avant de les hacher dans la base
    public static function checkPasswordStrength(string $pass, int $minimumLength): bool
    {
        $length = false;
        if (strlen($pass) > $minimumLength) {
            $length = true; // longueur minimale
        }
        $digit = preg_match("#\d#", $pass); // au moins un digit
        $special = preg_match("#\W#", $pass); // au moins un car. spécial
        $lower = preg_match("#[a-z]#", $pass); // au moins une minuscule
        $upper = preg_match("#[A-Z]#", $pass); // au moins une majuscule

        return $length && $digit && $special && $lower && $upper;
    }

    public static function authenticate(string $email, string $mdpUser): User
    {
        $db = ConnectionFactory::makeConnection();
        $query = "SELECT * from users where email = ?";


        $stmt = $db->prepare($query);
        $res = $stmt->execute([$email]); // [$email]

        // execute renvoie un booleen si aucune donnee execute, pareil pour fetch
        if (!$res) throw new AuthException("failed to check user in database");

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$user) throw new AuthException("invalid credentials : invalid email or password");
        if (!password_verify($mdpUser, $user['password'])) throw new AuthException("invalid credentials : invalid email or password");
        if ($user['active'] == 0){
            $url =ActiveAction::creationActivationToken($email);
            throw new AuthException("Your account is not active, please activate it : </br> <a href=\"$url\">Activate</a>");
        }

        return new User($email);
    }

    public static function register(string $email, string $pass): string
    {
        if (!self::checkPasswordStrength($pass, 7)) {
            throw new AuthException("password not enought strong : password must have at list <br>1 number, <br>1 Upper and Lower Case,<br>1 special caracters(!:;,...) <br>7 characters or more");
        } else {
            $hash = password_hash($pass, PASSWORD_DEFAULT, ['cost' => 12]);
            try {
                $db = ConnectionFactory::makeConnection();
            } catch (PDOException $e) {
                throw new AuthException($e->getMessage());
            }
            $query_email = "select * from users where email = ?";
            $stmt = $db->prepare($query_email);
            $stmt->execute([$email]);
            if ($stmt->fetch()) {
                throw new AuthException("account already exist");
            } else {
                try {
                    $query = "insert into users values (?, ?,null,null,null,null,0,null,null,null,null)";
                    $stmt = $db->prepare($query);

                    $stmt->execute([$email, $hash]);

                    //creation de l'url de validation
                    $url_act = ActiveAction::creationActivationToken($email);

                } catch (PDOException $e) {
                    throw new AuthException("erreur de création de compte : " . $e->getMessage());
                }
            }
        }

        return $url_act;
    }
}


?>

