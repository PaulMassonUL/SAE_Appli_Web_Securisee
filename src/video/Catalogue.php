<?php

namespace netvod\video;

use netvod\db\ConnectionFactory;
use netvod\exception\InvalidPropertyNameException;
use netvod\filtre\Tri;
use netvod\filtre\TriDate;
use netvod\filtre\TriEpisodes;
use netvod\filtre\TriNormal;
use netvod\filtre\TriNote;
use netvod\filtre\TriTitre;
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
     * @var Tri filtre
     * correspond au filtre utilisé
     */
    protected Tri $filtre;

    /**
     * Consructeur par défaut
     */
    public function __construct()
    {
        $this->series = $this->getSeries();
    }

    protected function getSeries(): array
    {
        $connection = ConnectionFactory::makeConnection();
        $resultset = $connection->prepare("SELECT * FROM serie");
        $resultset->execute();
        $connection = null;

        $this->series = $this->retrieveSerieList($resultset);

        if (isset($this->filtre)) {
            return $this->filtre->filtrer($this->series);
        }
        return $this->series;
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

    public function appliquerFiltre(int $filtre): void
    {
        switch ($filtre) {
            case Tri::FILTRE_NORMAL:
                $this->filtre = new TriNormal($this->series);
                break;
            case Tri::FILTRE_TITRE:
                $this->filtre = new TriTitre($this->series);
                break;
            case Tri::FILTRE_DATE:
                $this->filtre = new TriDate($this->series);
                break;
            case Tri::FILTRE_EPISODES:
                $this->filtre = new TriEpisodes($this->series);
                break;
            case Tri::FILTRE_NOTE:
                $this->filtre = new TriNote($this->series);
                break;
        }
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

