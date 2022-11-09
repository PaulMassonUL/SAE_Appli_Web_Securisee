<?php

namespace netvod\video;

use netvod\db\ConnectionFactory;
use netvod\exception\InvalidPropertyNameException;

class Episode
{
    private int $idepisode;
    /**
     * @var int $numero
     * numero de l'episode
     */
    private int $numero;

    /**
     * @var string $titre
     * correspond au titre de l'épisode
     */
    private string $titre;

    /**
     * @var string $resume
     * correspond au résumé de l'épisode
     */
    private string $resume;

    /**
     * @var string $duree
     * correspond à la durée de l'épisode
     */
    private string $duree;

    /**
     * @var string $fichier
     * correspond au fichier de l'épisode
     */
    private string $fichier;

    /**
     * @param int $num
     * @param string $titre
     * @param string $resume
     * @param string $duree
     * @param string $fichier
     * constructeur paramétré
     */
    public function __construct(int $idepisode,int $num, string $titre, string $resume, string $duree, string $fichier)
    {
        $this->idepisode = $idepisode;
        $this->numero = $num;
        $this->titre = $titre;
        $this->resume = $resume;
        $this->duree = $duree;
        $this->fichier = $fichier;
    }

    /**
     * @return bool
     * vérifie si un épisode a déjà été vu par l'utilisateur
     */
    public function estVu() : bool
    {
        $connection = ConnectionFactory::makeConnection();
        $resultset = $connection->prepare("SELECT * FROM episodeVisionne WHERE idEpisode = :id");
        $resultset->execute(['id' => $this->id]);

        $episodes = [];
        while ($row = $resultset->fetch()) {
            $episodes[] = new Episode($row['idepisode'] ,$row['numero'], $row['titre'], $row['resume'], $row['duree'], $row['file']);
        }
        return $episodes;
    }

    /**
     * @param $attrname
     * @return mixed
     * @throws InvalidPropertyNameException
     * getter magique
     */
    public function __get($attrname)
    {
        if (property_exists($this, $attrname)) return $this->$attrname;
        throw new InvalidPropertyNameException("Nom d'attribut invalide : $attrname");
    }

    /**
     * @param $attrname
     * @param $value
     * @return void
     * @throws InvalidPropertyNameException
     * Setter magique
     */
    public function __set($attrname, $value)
    {
        if (property_exists($this, $attrname)) $this->$attrname = $value;
        else throw new InvalidPropertyNameException("Nom d'attribut invalide : $attrname");
    }
}