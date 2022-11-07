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
        switch ($selector)
        {
            case Renderer::COMPACT:
                foreach ($this->catalogue->getSeries() as $serie) {
                    $serieRend = new SerieRenderer($serie);
                    $html .= $serieRend->render(Renderer::COMPACT);
                }
                break;
            case Renderer::DETAIL :
                foreach ($this->catalogue->getSeries() as $serie) {
                    $serieRend = new SerieRenderer($serie);
                    $html .= $serieRend->render(Renderer::DETAIL);
                }
                break;
            default:
                throw new \Exception("erreur de parametre");
        }

        return $html;
    }

}