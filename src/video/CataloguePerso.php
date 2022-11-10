<?php

namespace netvod\video;

class CataloguePerso extends Catalogue {

    private string $motscles;


    public function __construct(string $motscles) {
        $this->motscles = $motscles;
        $this->nom = "Series Searched";
        parent::__construct();
    }

    public function getSeries(): array
    {
        $connection = ConnectionFactory::makeConnection();
        switch ($this->tri) {
            case self::TRI_TITRE:
                $sql = "SELECT * FROM serie WHERE titre LIKE '%?%' OR descriptif LIKE '%?%' ORDER BY titre";
                break;
            case self::TRI_DATE:
                $sql = "SELECT * FROM serie WHERE titre LIKE '%?%' OR descriptif LIKE '%?%' ORDER BY date_creation";
                break;
            case self::TRI_EPISODES:
                $sql = "SELECT * FROM serie WHERE titre LIKE '%?%' OR descriptif LIKE '%?%' ORDER BY nb_episodes";
                break;
            case self::TRI_NOTE:
                $sql = "SELECT * FROM serie WHERE titre LIKE '%?%' OR descriptif LIKE '%?%' ORDER BY note";
                break;
            default:
                $sql = "SELECT * FROM serie WHERE titre LIKE '%?%' OR descriptif LIKE '%?%'";
        }
        $resultset = $connection->prepare($sql);
        $resultset->execute([$this->motscles]);
        $connection = null;

        return $this->retrieveSerieList($resultset);
    }


}