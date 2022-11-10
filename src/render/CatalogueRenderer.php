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
        $tri = "";
        $html .= '<div id="triChoix"> <p> Quel tri voulez vous prendre ? : </p> ';
        $html .= '<ol> <ul> par defaut : 0 </ul> <ul> par titre : 1 </ul> <ul> par date : 2 </ul> <ul> par Nb d\'episodes : 3 </ul> <ul> par noteMoyenne : 4 </ul> </ol>';
        $html .= '<form id="choix" action = "?action=addChoiceTriCatalogue" method="post">';
        $html .= '<input type="number" name="choixTri" placeholder="0-4" min="0" max="4" > <button type="submit"> Valider </button>';
        $html .= '</form>';
        $html .= '</div>';
        foreach ($this->catalogue->__get("series") as $serie) {
            $renderer = new SerieRenderer($serie);
            $html .= $renderer->render(Renderer::COMPACT);
        }
        $html .= '</div></div>';
        return $html;
    }

}