<?php

namespace netvod\video;

use netvod\db\ConnectionFactory;
use netvod\exception\InvalidPropertyNameException;
use netvod\avis\Note;

class Serie
{
    private int $id;

    private string $titre;

    private string $descriptif;

    private string $image;

    private int $annee;

    private string $dateAjout;

    private array $genres;

    private array $publics;

    private array $episodes;


    public function __construct(int $id, string $t, string $desc, string $img, int $annee, string $dateAjout, array $genres, array $publics)
    {
        $this->id = $id;
        $this->titre = $t;
        $this->descriptif = $desc;
        $this->image = $img;
        $this->annee = $annee;
        $this->dateAjout = $dateAjout;
        $this->genres = $genres;
        $this->publics = $publics;
        $this->episodes = $this->getEpisodes();
    }

    private function getEpisodes(): array
    {
        $connection = ConnectionFactory::makeConnection();
        $resultset = $connection->prepare("SELECT * FROM episode WHERE serie_id = :id");
        $resultset->execute(['id' => $this->id]);

        $episodes = [];
        while ($row = $resultset->fetch()) {
            $episodes[] = new Episode($row['numero'], $row['titre'], $row['resume'], $row['duree'], $row['file']);
        }
        return $episodes;
    }

    /**
     * @return bool true si la série est en cours, false sinon
     */
    public function estEnCours(): bool
    {
        foreach ($this->episodes as $ep) {
            if ($ep->estVu()) {
                return true;
            }
        }
        return false;
    }

    public function estNotee(): bool
    {
        return false;
    }

    public function estCommentee(): bool
    {
        return false;
    }

    public function getNote(): float
    {
        return 0.0;
    }

    public function getEpisodeByNum(int $num): ?Episode
    {
        foreach ($this->episodes as $ep) {
            if ($ep->__get("numero") == $num) {
                return $ep;
            }
        }
        return null;
    }

    public function __get($attrname)
    {
        if (property_exists($this, $attrname)) return $this->$attrname;
        throw new InvalidPropertyNameException("Nom d'attribut invalide : $attrname");
    }

    public function __set($attrname, $value)
    {
        if (property_exists($this, $attrname)) $this->$attrname = $value;
        else throw new InvalidPropertyNameException("Nom d'attribut invalide : $attrname");
    }
}