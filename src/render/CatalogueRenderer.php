<?php

namespace netvod\render;

use netvod\exception\InvalidPropertyNameException;
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
        $html = '<div id="catalog-container">';
        try {
            $nom = $this->catalogue->__get("nom");
        } catch (InvalidPropertyNameException $e) {
            $nom = "CATALOG";
        }
        $html .= '<div><label id="title">' . $nom . '</label></div>';
        $html .= '<div id="catalog">';
//        $this->catalogue->definirTri(Catalogue::TRI_NORMAL);
        foreach ($this->catalogue->__get("series") as $serie) {
            $renderer = new SerieRenderer($serie);
            $html .= $renderer->render(Renderer::COMPACT);
        }
        $html .= '</div></div>';
        return $html;
    }

}