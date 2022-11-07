<?php

namespace \netvod\video;

class Serie {

    private string $titre;

    private string $image;

    private string $genre;

    private string $public;

    private string $descriptif;

    private string $dateAjout;

    private Note $notes;

    private float $note = 0;

    private boolean $commentee = false;

    private boolean $preferee = false;

    private boolean $enCours = false;


    private array $episodes;

    private array $commentaires;


    public function __construct(string $t, string $img, string $genre, string $public,
                                string $desc, string $annee)
    {
        $this->titre = $t;
        $this->image = $img;
        $this->genre = $genre;
        $this->public = $public;
        $this->descriptif = $desc;
        $this->episodes = [];
        $this->commentaires = [];
    }

    public function ajouterEpisode(Episode $ep) : void
    {
        $this->episodes = ep;
    }

    public function supprmierEpisode(int $i) : void
    {
        unset($this->episodes[i]);
    }
}