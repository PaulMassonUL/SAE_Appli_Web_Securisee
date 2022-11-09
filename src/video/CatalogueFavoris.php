<?php

namespace netvod\video;

use netvod\db\ConnectionFactory;

class CatalogueFavoris extends Catalogue
{

    /**
     * Constructeur du catalogue global
     */
    public function __construct()
    {
        $this->nom = "Favorite Series";
        parent::__construct();
    }

    protected function getSeries() : array
    {
        $connection = ConnectionFactory::makeConnection();
        $resultset = $connection->prepare("SELECT * FROM serie, seriePreferee WHERE seriePreferee.idSerie = serie.id AND seriePreferee.email = :email");

        $series = [];
        $user = unserialize($_SESSION['user']);
        if (!is_null($user)) {
            $resultset->execute(['email' => $user->__get("email")]);
            $connection = null;
            $series = $this->retrieveSerieList($resultset);
        }

        return $series;
    }

}

