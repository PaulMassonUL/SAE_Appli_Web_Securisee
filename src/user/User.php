<?php

namespace netvod\user;

use netvod\db\ConnectionFactory;
use netvod\video\Catalogue;
use netvod\video\Serie;

class User
{
    /**
     * email de l'utilisateur
     */
    private string $email;

    /**
     * @param string $eml email
     * @param string $pwd mot de passe
     */
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

    /**
     * @return Catalogue
     */
    public function getSeriesEnCours() : Catalogue
    {
        return new Catalogue("Series in progress", []);
    }
}