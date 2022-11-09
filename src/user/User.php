<?php

namespace netvod\user;

use netvod\db\ConnectionFactory;
use netvod\exception\InvalidPropertyNameException;
use netvod\video\Catalogue;
use netvod\video\Episode;
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
            $series[] = new Serie($row['id'], $row['titre'], $row['descriptif'], $row['img'], $row['annee'], $row['date_ajout'], ["genre"], ["public"]);
        }
        $connection = null;
        return new Catalogue("Favorite Series", $series);
    }


    public function getSeriesEnCours() : Catalogue {
        $series = [];
        foreach ($this->getCatalogue()->__get("series") as $serie) {
            if ($serie->estEnCours()) {
                $series[] = $serie;
            }
        }
        return new Catalogue("Favorite Series", $series);
    }

    public function voirEpisode(Episode $e) : void {
        try {
            $query = "INSERT INTO episodeVisionne VALUES ( ? , ? )";
            $db = ConnectionFactory::makeConnection();
            $st = $db->prepare($query);
            $st->execute([$e->__get('numero'), $this->email]);
        } catch (PDOException $e) {
            throw new \Exception("erreur d'insersion dans catalogue en cours");
        } catch (InvalidPropertyNameException $e) {
            throw new \Exception("nom incorrecte");
        }
    }
}