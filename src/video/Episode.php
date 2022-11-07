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

    /**
     * @return string
     */
    public function getImage(): string
    {
        return $this->image;
    }

    /**
     * @param string $image
     */
    public function setImage(string $image): void
    {
        $this->image = $image;
    }

    /**
     * @return string
     */
    public function getTitre(): string
    {
        return $this->titre;
    }

    /**
     * @param string $titre
     */
    public function setTitre(string $titre): void
    {
        $this->titre = $titre;
    }

    /**
     * @return string
     */
    public function getResume(): string
    {
        return $this->resume;
    }

    /**
     * @param string $resume
     */
    public function setResume(string $resume): void
    {
        $this->resume = $resume;
    }

    /**
     * @return float
     */
    public function getDuree(): float
    {
        return $this->duree;
    }

    /**
     * @param float $duree
     */
    public function setDuree(float $duree): void
    {
        $this->duree = $duree;
    }

    /**
     * @return bool
     */
    public function isEstVu(): bool
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