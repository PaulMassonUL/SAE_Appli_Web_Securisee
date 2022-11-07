<?php

namespace netvod\video;

use netvod\avis\Commentaire;
use netvod\avis\Note;

class Serie {

    private string $titre;

    private string $image;

    private string $genre;

    private string $public;

    private string $descriptif;

    private int $anneeSortie;

    private string $dateAjout;

    private Note $notes;

    private float $note = 0;

    private boolean $commentee = false;

    private boolean $preferee = false;

    private boolean $enCours = false;


    private array $episodes;

    private array $commentaires;


    public function __construct(string $t, string $img, string $genre, string $public,
                                string $desc, int $annee, string $dateAjout)
    {
        $this->titre = $t;
        $this->image = $img;
        $this->genre = $genre;
        $this->public = $public;
        $this->descriptif = $desc;
        $this->anneeSortie = $annee;
        $this->dateAjout = $dateAjout;
        $this->episodes = [];
        $this->commentaires = [];
    }

    public function ajouterEpisode(Episode $ep) : void
    {
        $this->episodes[] = $ep;
    }

    public function supprimerEpisode(Episode $ep) : void
    {
        unset($this->episodes[array_search($ep, $this->episodes)]);
    }

    public function getEpisodes(): array
    {
        return $this->episodes;
    }

    /**
     * @return string
     */
    public function getImage(): string
    {
        return $this->image;
    }

    /**
     * @return string
     */
    public function getTitre(): string
    {
        return $this->titre;
    }

    /**
     * @return string
     */
    public function getGenre(): string
    {
        return $this->genre;
    }

    /**
     * @return int
     */
    public function getAnneeSortie(): int
    {
        return $this->anneeSortie;
    }

    /**
     * @return string
     */
    public function getDescriptif(): string
    {
        return $this->descriptif;
    }

    /**
     * @return string
     */
    public function getPublic(): string
    {
        return $this->public;
    }

    /**
     * @return string
     */
    public function getDateAjout(): string
    {
        return $this->dateAjout;
    }

    /**
     * @return tableau de commentaires
     */
    public function getCommentaires(): array
    {
       return $this->commentaires;
    }
}