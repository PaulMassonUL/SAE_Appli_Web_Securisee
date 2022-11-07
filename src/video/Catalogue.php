<?php

namespace netvod\video;

use iutnc\deefy\exception\InvalidPropertyNameException;

class Catalogue {

    /**
     * Series of the catalog
     */
    private array $series;

    /**
     * constructor initializes the series array
     */
    public function __construct()
    {
        $this->series = [];
    }

    /**
     * Add a serie to the catalog
     * @param $s the serie to add
     */
    public function ajouterSerie(Serie $s) : void
    {
        $this->series[] = $s;
    }

    /**
     * getter
     * @param $attrname attribute name
     * @return mixed attribute value
     * @throws InvalidPropertyNameException if the attribute name is invalid
     */
    public function __get($attname) {
        if (property_exists($this, $attname)) return $this->$attname;
        throw new InvalidPropertyNameException("Nom d'attribut invalide : $attname");
    }

}

