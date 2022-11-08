<?php

namespace netvod\user;

use netvod\video\Catalogue;

class User
{
    private static ?User $instance = null;

    public static function getInstance(): ?User
    {
        return self::$instance;
    }

    public static function setInstance(User $user): void
    {
        self::$instance = $user;
        $_SESSION['user'] = true;
    }

    /**
     * email de l'utilisateur
     */
    private string $email;

    /**
     * mot de passe de l'utilisateur
     */
    private string $passwd;

    /**
     * catalogue de l'utilisateur
     */
    private Catalogue $catalogue;

    /**
     * liste de series preferées de l'utilisateur
     */
    private Catalogue $seriesPref;

    /**
     * @param string $eml email
     * @param string $pwd mot de passe
     */
    public function __construct(string $eml, string $pwd)
    {
        $this->email = $eml;
        $this->passwd = $pwd;
    }

    /**
     * @return Catalogue
     */
    public function getCatalogue(): Catalogue
    {
        return $this->catalogue;
    }

    /**
     * @return Catalogue
     */
    public function getSeriesPref(): Catalogue
    {
        return $this->seriesPref;
    }
}