<?php

namespace netvod\video;

use netvod\exception\InvalidPropertyNameException;
use netvod\avis\Note;

class Serie
{
    /**
     * @var int id de la série
     */
    private int $id;

    /**
     * @var string titre de l'épisode
     */
    private string $titre;

    /**
     * @var string chemin du fichier
     */
    private string $image;

    /**
     * @var string genre de la série
     */
    private string $genre;

    /**
     * @var string public de la série
     */
    private string $public;

    /**
     * @var string descriptif de la série
     */
    private string $descriptif;

    /**
     * @var int année de sortie de la série
     */
    private int $anneeSortie;

    /**
     * @var string date d'ajout sur le site
     */
    private string $dateAjout;

    //TODO à commenter
    private Note $notes;

    /**
     * @var float|int note donné à la série par l'utilisateut
     */
    private float $note = 0;

    /**
    private bool $commentee = false;*/

    /**
     * @var bool test si la série appartient à la liste des séries préférées de l'utilisateur
     */
    private bool $preferee = false;

    /**
     * @var array liste des épisodes
     */
    private array $episodes;

    /**
     * @var array liste des commentaires
     */
    private array $commentaires;

    /**
     * @param int $id
     * @param string $t
     * @param string $img
     * @param string $genre
     * @param string $public
     * @param string $desc
     * @param int $annee
     * @param string $dateAjout
     * constructeur paramétré
     */
    public function __construct(int    $id, string $t, string $img, string $genre, string $public,
                                string $desc, int $annee, string $dateAjout)
    {
        $this->id = $id;
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

    /**
     * @param Episode $ep
     * @return void
     * permet d'ajouter un épisode à une série
     */
    public function ajouterEpisode(Episode $ep): void
    {
        $this->episodes[] = $ep;
    }

    /**
     * @param Episode $ep
     * @return void
     * permet de supprimer un épisode d'une série
     */
    public function supprimerEpisode(Episode $ep): void
    {
        unset($this->episodes[array_search($ep, $this->episodes)]);
    }

    /**
     * @return bool
     * vérifie si la série est en cours
     */
    public function estEnCours(): bool
    {
        foreach ($this->episodes as $ep) {
            if ($ep->__get("vu")) {
                return true;
            }
        }
        return false;
    }

    /**
     * @param int $num
     * @return Episode|null
     * permet de récupérer un épisode par son numéro
     */
    public function getEpisodeByNum(int $num): ?Episode
    {
        foreach ($this->episodes as $ep) {
            if ($ep->__get("numero") == $num) {
                return $ep;
            }
        }
        return null;
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
     * setter magique
     */
    public function __set($attrname, $value)
    {
        if (property_exists($this, $attrname)) $this->$attrname = $value;
        else throw new InvalidPropertyNameException("Nom d'attribut invalide : $attrname");
    }
}