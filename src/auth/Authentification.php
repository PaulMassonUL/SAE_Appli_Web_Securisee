<?php
namespace iutnc\deefy\auth;
use iutnc\deefy\auth\User as User;
use PDO;
use iutnc\deefy\db\ConnectionFactory as ConnectionFactory;
use iutnc\deefy\AuthException\AuthException as AuthException;

class Auth
{

    // controler la solidité des mots de passe avant de les hacher dans la base
    public static function checkPasswordStrength(string $pass, int $minimumLength): bool {
        $length = (strlen($pass) < $minimumLength); // longueur minimale
        $digit = preg_match("#[\d]#", $pass); // au moins un digit
        $special = preg_match("#[\W]#", $pass); // au moins un car. spécial
        $lower = preg_match("#[a-z]#", $pass); // au moins une minuscule
        $upper = preg_match("#[A-Z]#", $pass); // au moins une majuscule
        if (!$length || !$digit || !$special || !$lower || !$upper) return false;
        return true;
    }

    public static function authenticate(string $email, string $mdpUser) : void
    {
        /*$hash = "select passwd from user where email = $email ";
        if (!password_verify($mdpUser, $hash)) return new User($email, $mdpUser, 1);
        return null; */
        $db = ConnectionFactory::makeConnection();
        $query = "SELECT * from user where email = ?";


        $stmt = $db->prepare($query);
        $res = $stmt->execute([$email]); // [$email]

        // execute renvoie un booleen si aucune donnee execute, pareil pour fetch
        if (!$res) throw new AuthException("auth error : db query failed");

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$user ) throw new AuthException("auth failed : invalid credentials");
        if (!password_verify($mdpUser, $user['passwd'])) throw new AuthException("auth failed : invalid credentials");
        //$user = new User($email, $user['passwd'], $user['role']);
        //$_SESSION['user'] = serialize($user);

        return; //$user;
    }

    public static function register(string $email, string $pass) : bool
    {
        if (!self::checkPasswordStrength($pass, 4))
            throw new AuthException("password trop faible");
        $hash = password_hash($pass, PASSWORD_DEFAULT, ['cost' => 12]);
        try
        {
            $db = ConnectionFactory::makeConnection();
        }
        catch (DBException $e)
        {
            throw new AuthException($e->getMessage());
        }
        $query_email = "select * from user where email = ?";
        $stmt = $db->prepare($query_email);
        $res = $stmt->execute([$email]);
        if ($stmt->fetch()) throw new AuthException("compte deja existant");

        try {
            $query = "insert into user (email, passwd) values (?, ?)";
            $stmt = $db->prepare($query);
            $res = $stmt->execute([$email, $hash]);
        } catch (\PDOException $e) {
            throw new AuthException("erreur de création de compte : ".$e->getMessage());
        }

        return true;
    }
}


?>

