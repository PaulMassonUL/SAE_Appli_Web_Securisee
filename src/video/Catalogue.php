<?php

namespace netvod\video;

use iutnc\deefy\exception\InvalidPropertyNameException;

class Catalogue
{
    /**
     * @var array
     * correspond à la liste des séries
     */
    private array $series;

    /**
     * @param array $series
     * Constructeur paramétré
     */
    public function __construct(array $series)
    {
        $this->series = $series;
    }

    /**
     * @param Serie $s
     * @return void
     * Ajoute une série à la liste
     */
    public function ajouterSerie(Serie $s): void
    {
        $this->series[] = $s;
    }

    /**
     * @param $attname
     * @return mixed
     * @throws InvalidPropertyNameException
     * Getter
     */
    public function __get($attname)
    {
        if (property_exists($this, $attname)) return $this->$attname;
        throw new InvalidPropertyNameException("Nom d'attribut invalide : $attname");
    }

}

