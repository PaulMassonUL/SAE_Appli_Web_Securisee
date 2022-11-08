<?php

namespace netvod\action;

use netvod\render\Renderer;
use netvod\render\SerieRenderer;
use netvod\video\Serie;

class ShowDetailsAction extends Action
{
    private Serie $serie;

    /**
     * @param Serie $serie
     */
    public function __construct(Serie $serie)
    {
        $this->serie = $serie;
        parent::__construct();
    }

    public function execute(): string
    {
        $renderer = new SerieRenderer($this->serie);
        return $renderer->render(Renderer::DETAIL);
    }
}