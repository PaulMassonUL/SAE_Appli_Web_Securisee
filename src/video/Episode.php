<?php

namespace netvod\video;

use netvod\db\ConnectionFactory;
use netvod\exception\InvalidPropertyNameException;

class Episode
{

    /**
     * @var int
     * id de l'épisode
     */
    private int $id;

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
    public function __construct(int $id, int $num, string $titre, string $resume, string $duree, string $fichier)
    {
        $this->id = $id;
        $this->numero = $num;
        $this->titre = $titre;
        $this->resume = $resume;
        $this->duree = $duree;
        $this->fichier = $fichier;
    }


    public function estVu() : bool
    {
        $connection = ConnectionFactory::makeConnection();
        $resultset = $connection->prepare("SELECT count(*) as nb FROM episodeVisionne WHERE idEpisode = :id and email = :email");
        $user = unserialize($_SESSION['user']);
        $resultset->execute(['id' => $this->id, 'email' => $user->__get("email")]);

        $row = $resultset->fetch();
        return $row['nb'] == 1;
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