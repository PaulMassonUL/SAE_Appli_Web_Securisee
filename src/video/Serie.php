<?php

namespace netvod\video;

use iutnc\deefy\exception\InvalidPropertyNameException;
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

    private bool $commentee = false;

    private bool $preferee = false;

    private bool $enCours = false;


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