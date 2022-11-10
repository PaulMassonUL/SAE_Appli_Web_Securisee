<?php

namespace netvod\user;

use netvod\db\ConnectionFactory;
use netvod\exception\InvalidPropertyNameException;
use netvod\video\Catalogue;
use netvod\video\CatalogueEncours;
use netvod\video\CatalogueFavoris;
use netvod\video\CataloguePerso;
use netvod\video\CatalogueFini;

class User
{
    /**
     * email de l'utilisateur
     */
    private string $email;

    private string $nom;

    private string $prenom;

    private string $age;

    private string $genrePref;

    public function __construct(string $eml, string $nom, string $prenom, string $age, string $genrePref)
    {
        $this->email = $eml;
        $this->nom = $nom;
        $this->prenom = $prenom;
        $this->age = $age;
        $this->genrePref = $genrePref;
    }

    public function updateProfile(string $nom, string $prenom, string $age, string $genrePref): void
    {
        $this->nom = $nom;
        $this->prenom = $prenom;
        $this->age = $age;
        $this->genrePref = $genrePref;

        $_SESSION['user'] = serialize($this);

        $connection = ConnectionFactory::makeConnection();
        $sql = "UPDATE users SET nom = ?, prenom = ?, age = ?, genrePref = ? WHERE email = ?";
        $statement = $connection->prepare($sql);
        $statement->execute([$nom, $prenom, intval($age), $genrePref, $this->email]);
    }

    /**
     * @return Catalogue catalogue principal
     */
    public function getCatalogue(): Catalogue
    {
        return new Catalogue();
    }

    public function getCataloguePerso(string $mots): Catalogue {
        return new CataloguePerso($mots);
    }

    /**
     * @return Catalogue catalogue de favoris
     */
    public function getSeriesPref(): Catalogue
    {
        return new CatalogueFavoris();
    }

    /**
     * @return Catalogue catalogue de series en cours
     */
    public function getSeriesEnCours(): Catalogue
    {
        return new CatalogueEncours();
    }

    public function getSeriesFinies() : Catalogue {
        return new CatalogueFini();
    }



    public function __get($attrname)
    {
        if (property_exists($this, $attrname)) return $this->$attrname;
        throw new InvalidPropertyNameException("Nom d'attribut invalide : $attrname");
    }
}