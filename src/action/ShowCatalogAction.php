<?php

namespace netvod\action;

use netvod\render\CatalogueRenderer;
use netvod\render\Renderer;
use netvod\video\Catalogue;

class ShowCatalogAction extends Action
{

    private Catalogue $catalogue;

    /**
     * @param Catalogue $catalogue
     */
    public function __construct(Catalogue $catalogue)
    {
        $this->catalogue = $catalogue;
        parent::__construct();
    }

    public function execute(): string
    {
        $renderer = new CatalogueRenderer($this->catalogue);

        $html = '<form method="post" action="?action=show-details-serie">';
        $html .= $renderer->render(Renderer::COMPACT);
        $html .= '</form>';
        return $html;
    }
}