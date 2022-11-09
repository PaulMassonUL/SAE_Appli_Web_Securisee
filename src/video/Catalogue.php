<?php

namespace netvod\video;

use netvod\db\ConnectionFactory;
use netvod\exception\InvalidPropertyNameException;
use PDOStatement;

class Catalogue
{
    /**
     * @var string
     * nom du catalogue
     */
    protected string $nom = "Available Series";

    /**
     * @var array
     * correspond à la liste des séries
     */
    protected array $series;

    /**
     * Consructeur par défaut
     */
    public function __construct()
    {
        $this->series = $this->getSeries();
    }

    protected function getSeries() : array
    {
        $connection = ConnectionFactory::makeConnection();
        $resultset = $connection->prepare("SELECT * FROM serie");
        $resultset->execute();
        $connection = null;

        return $this->retrieveSerieList($resultset);
    }

    protected function retrieveSerieList(PDOStatement $resultSet) : array
    {
        $series = [];
        while ($row = $resultSet->fetch()) {
            $series[] = new Serie($row['id'], $row['titre'], $row['descriptif'], $row['img'], $row['annee'], $row['date_ajout'], ["genre"], ["public"]);
        }
        return $series;
    }

    public function getSerieById(int $id) : ?Serie
    {
        foreach ($this->series as $serie) {
            if ($serie->__get('id') == $id) {
                return $serie;
            }
        }
        return null;
    }

    /**
     * @param $attname
     * @return mixed
     * @throws InvalidPropertyNameException
     * Getter
     */
    public function __get($attname)
    {
        if (property_exists($this, $attname)) return $this->$attname;
        throw new InvalidPropertyNameException("Nom d'attribut invalide : $attname");
    }

}

