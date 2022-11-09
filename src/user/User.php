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

    public function ajouterSerieEnCours(Serie $s): void
    {
        try {
            $query = "INSERT INTO serieVisionnee VALUES ( ? , ? )";
            $db = ConnectionFactory::makeConnection();
            $st = $db->prepare($query);
            $st->execute([$s->__GET('id'), $this->email]);
        } catch (PDOException $e) {
            throw new \Exception("erreur d'insersion dans catalogue en cours");
        } catch (InvalidPropertyNameException $e) {
            throw new \Exception("nom incorrecte");
        }
    }

    public function __get($attrname)
    {
        if (property_exists($this, $attrname)) return $this->$attrname;
        throw new InvalidPropertyNameException("Nom d'attribut invalide : $attrname");
    }
}