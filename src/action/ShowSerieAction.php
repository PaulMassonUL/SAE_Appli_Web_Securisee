<?php

namespace netvod\action;

use netvod\render\Renderer;
use netvod\render\SerieRenderer;
use netvod\video\Serie;

class ShowSerieAction extends Action
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

        $html = '<form method="post" action="?action=show-episode-details">';
        $html .= '<input type="hidden" name="serieId" value="' . $this->serie->__get("id") . '">';
        $html .= $renderer->render(Renderer::DETAIL);
        $html .= '</form>';
        return $html;
    }
}