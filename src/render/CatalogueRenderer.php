<?php

namespace netvod\render;

use netvod\video\Catalogue;

class CatalogueRenderer implements Renderer
{

    private Catalogue $catalogue;

    public function __construct(Catalogue $catalogue)
    {
        $this->catalogue = $catalogue;
    }

    public function render(int $selector): string
    {
        $html = "";
        foreach ($this->catalogue->__get("series") as $serie) {
            $renderer = new SerieRenderer($serie);
            $html .= $renderer->render(Renderer::COMPACT);
        }
        return $html;
    }

}