<?php

namespace netvod\action;

use netvod\video\Serie;

class ShowCommentAction extends Action {

    private Serie $serie;


    public function __construct(Serie $serie)
    {
        $this->serie = $serie;
    }

    public function execute(): string
    {
        return $this->serie->AfficherCommentaires();
    }


}