<?php

namespace netvod\video;

class Episode
{
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
     * @var float $duree
     * correspond à la durée de l'épisode
     */
    private float $duree;

    /**
     * @var bool $estVu
     * indique si l'épisode à déjà été vu par l'utilisateur
     */
    private bool $estVu;

    /**
     * @param string $image
     * @param string $titre
     * @param string $resume
     * @param float $duree
     * @param bool $estVu
     */
    public function __construct(string $image, string $titre, string $resume, float $duree, bool $estVu)
    {
        $this->image = $image;
        $this->titre = $titre;
        $this->resume = $resume;
        $this->duree = $duree;
        $this->estVu = $estVu;
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

    /**
     * @return bool
     */
    public function estVu(): bool
    {
        return $this->estVu;
    }

    /**
     * @param bool $estVu
     */
    public function setEstVu(bool $estVu): void
    {
        $this->estVu = $estVu;
    }
}