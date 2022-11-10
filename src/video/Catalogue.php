<?php

namespace netvod\video;

use netvod\db\ConnectionFactory;
use netvod\exception\InvalidPropertyNameException;
use PDOStatement;

class Catalogue
{

    const TRI_NORMAL = 0;
    const TRI_TITRE = 1;
    const TRI_DATE = 2;
    const TRI_EPISODES = 3;
    const TRI_NOTE = 4;

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
     * @var int
     * correspond au tri utilisé
     */
    protected int $tri;

    /**
     * Consructeur par défaut
     */
    public function __construct()
    {
        $this->tri = self::TRI_NORMAL;
        $this->series = $this->getSeries();
    }

    protected function getSeries(): array
    {
        $connection = ConnectionFactory::makeConnection();
        switch ($this->tri) {
            case self::TRI_TITRE:
                $sql = "SELECT * FROM serie ORDER BY titre";
                break;
            case self::TRI_DATE:
                $sql = "SELECT * FROM serie ORDER BY date_creation";
                break;
            case self::TRI_EPISODES:
                $sql = "SELECT * FROM serie ORDER BY nb_episodes";
                break;
            case self::TRI_NOTE:
                $sql = "SELECT * FROM serie ORDER BY note";
                break;
            default:
                $sql = "SELECT * FROM serie";
        }
        $resultset = $connection->prepare($sql);
        $resultset->execute();
        $connection = null;

        return $this->retrieveSerieList($resultset);
    }

    protected function retrieveSerieList(PDOStatement $resultSet): array
    {
        $series = [];
        while ($row = $resultSet->fetch()) {
            $series[] = new Serie($row['id'], $row['titre'], $row['descriptif'], $row['img'], $row['annee'], $row['date_ajout'], $row['genre'], $row['public']);
        }
        return $series;
    }

    public function getSerieById(int $id): ?Serie
    {
        foreach ($this->series as $serie) {
            if ($serie->__get('id') == $id) {
                return $serie;
            }
        }
        return null;
    }

    public function definirTri(int $tri): void
    {
        $this->tri = $tri;
        $this->series = $this->getSeries();
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

