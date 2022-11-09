<?php

namespace netvod\action;

use netvod\video\Serie;

class AddSerieFavAction extends Action {

    private Serie $serie;

    public function __construct(Serie $serie) {
        $this->serie = $serie;
    }

    public function execute(): string
    {
        $this->serie->ajouterFavoris();
        return $html = $this->serie->__get('titre') . " ajouté aux favoris !!!";

    }
}