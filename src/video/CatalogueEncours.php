<?php

namespace netvod\video;

class CatalogueEncours extends Catalogue
{

    /**
     * Constructeur du catalogue global
     */
    public function __construct()
    {
        $this->nom = "Series in progress";
        parent::__construct();
    }

    protected function getSeries() : array
    {
        $series = [];
        foreach (parent::getSeries() as $serie) {
            if ($serie->estEnCours()) {
                $series[] = $serie;
            }
        }

        return $series;
    }

}

