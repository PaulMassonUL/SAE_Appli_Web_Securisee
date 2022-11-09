<?php

namespace netvod\action;

use netvod\render\CatalogueRenderer;
use netvod\render\Renderer;
use netvod\video\Catalogue;

class ShowCatalogAction extends Action
{

    /**
     * @var Catalogue
     */
    private Catalogue $catalogue;

    /**
     * @param Catalogue $catalogue
     * Constructeur paramétré
     */
    public function __construct(Catalogue $catalogue)
    {
        $this->catalogue = $catalogue;
        parent::__construct();
    }

    /**
     * @return string
     * execute l'action
     */
    public function execute(): string
    {
        $renderer = new CatalogueRenderer($this->catalogue);

        $html = '<form method="post" action="?action=show-serie-details">';
        $html .= $renderer->render(Renderer::COMPACT);
        $html .= '</form>';
        return $html;
    }
}