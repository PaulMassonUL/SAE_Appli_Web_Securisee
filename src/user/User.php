<?php

namespace netvod\user;

use netvod\db\ConnectionFactory;
use netvod\exception\InvalidPropertyNameException;
use netvod\video\Catalogue;
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
     * @return Catalogue
     */
    public function getCatalogue(): Catalogue
    {
        $connection = ConnectionFactory::makeConnection();
        $resultset = $connection->prepare("SELECT * FROM serie");
        $resultset->execute();

        $series = [];
        while ($row = $resultset->fetch()) {
            $series[] = new Serie($row['id'], $row['titre'], $row['descriptif'], $row['img'], $row['annee'], $row['date_ajout'], ["genre"], ["public"]);
        }
        $connection = null;

        return new Catalogue("Available Series", $series);
    }

    /**
     * @return Catalogue
     */
    public function getSeriesPref(): Catalogue
    {
        $connection = ConnectionFactory::makeConnection();
        $resultset = $connection->prepare("SELECT * FROM serie, seriePreferee WHERE seriePreferee.idSerie = serie.id AND seriePreferee.email = :email");
        $resultset->execute(['email' => $this->email]);

        $series = [];
        while ($row = $resultset->fetch()) {
            $series[] = new Serie($row['id'], $row['titre'], $row['descriptif'], $row['img'], $row['annee'], $row['date_ajout'], ["genre"], ["public"], $episodes);
        }
        $connection = null;
        return new Catalogue("Favorite Series", $series);
    }


    public function getSeriesEnCours() : Catalogue {
        $c = new Catalogue("enCours", []);
        $query = "SELECT * FROM serieVisionnee INNER JOIN serie WHERE email = ?";
        $db = ConnectionFactory::makeConnection();
        $st = $db->prepare($query);
        $res = $st->execute([$this->email]);
        if(  $res) {

        }
        return $c;
    }

    public function ajouterSerieEnCours(Serie $s) : void {
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
}