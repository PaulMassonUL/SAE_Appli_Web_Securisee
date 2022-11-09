<?php

namespace netvod\action;

use netvod\exception\InvalidPropertyNameException;
use netvod\render\Renderer;
use netvod\render\SerieRenderer;
use netvod\video\Serie;

class ShowSerieAction extends Action
{
    /**
     * @var Serie
     */
    private Serie $serie;

    /**
     * @param Serie $serie
     */
    public function __construct(Serie $serie)
    {
        $this->serie = $serie;
        parent::__construct();
    }

    /**
     * @return string
     * @throws InvalidPropertyNameException
     * execute l'action
     */
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