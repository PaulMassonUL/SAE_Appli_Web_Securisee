<?php

namespace netvod\video;

class CatalogueFini extends Catalogue {

    public function __construct()
    {
        $this->nom = "Finished Series";
        parent::__construct();
    }

    public function getSeries(): array
    {
        $series = [];
        foreach (parent::getSeries() as $serie) {
            if ($serie->estFini()) {
                $series[] = $serie;
            }
        }
        return $series;
    }
}