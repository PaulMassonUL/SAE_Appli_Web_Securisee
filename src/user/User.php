<?php

namespace netvod\user;

use netvod\db\ConnectionFactory;
use netvod\exception\InvalidPropertyNameException;
use netvod\video\Catalogue;
use netvod\video\CatalogueEncours;
use netvod\video\CatalogueFavoris;
use netvod\video\CatalogueGlobal;
use netvod\video\Serie;
use PDOException;

use netvod\avis\Commentaire;

class User
{
    /**
     * email de l'utilisateur
     */
    private string $email;


    public function __construct(string $eml)
    {
        $this->email = $eml;
    }

    /**
     * @return Catalogue catalogue principal
     */
    public function getCatalogue(): Catalogue
    {
        return new Catalogue();
    }

    public function getCataloguePerso(array $mots): Catalogue {
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



    public function __get($attrname)
    {
        if (property_exists($this, $attrname)) return $this->$attrname;
        throw new InvalidPropertyNameException("Nom d'attribut invalide : $attrname");
    }
}