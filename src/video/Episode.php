<?php

namespace netvod\video;

use iutnc\deefy\exception\InvalidPropertyNameException;

class Episode
{

    /**
     * @var int $numero
     * numero de l'episode
     */
    private int $numero;

    /**
     * @var string $image
     * correspond au chemin de l'image
     */
    private string $image;

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
     * @var bool $vu
     * indique si l'épisode à déjà été vu par l'utilisateur
     */
    private bool $vu;

    /**
     * @param string $image
     * @param string $titre
     * @param string $resume
     * @param string $duree
     * @param bool $vu
     */
    public function __construct(int $num, string $image, string $titre, string $resume, string $duree, bool $vu)
    {
        $this->numero = $num;
        $this->image = $image;
        $this->titre = $titre;
        $this->resume = $resume;
        $this->duree = $duree;
        $this->vu = $vu;
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