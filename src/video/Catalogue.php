<?php

namespace netvod\video;

use iutnc\deefy\exception\InvalidPropertyNameException;

class Catalogue {

    private array $series;

    public function __construct()
    {
        $this->series = [];
    }

    public function ajouterSerie(Serie $s) : void
    {
        $this->series[] = $s;
    }

    /**
     * @return array
     */
    public function getSeries(): array
    {
        return $this->series;
    }

    public function __get($attname) {
        if (property_exists($this, $attname)) return $this->$attname;
        throw new InvalidPropertyNameException("Nom d'attribut invalide : $attname");
    }

}

