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
        $html = '<div id="triChoix"> <p> Quel tri voulez vous prendre ? : </p> ';
        $html .= '<ol> <ul> par defaut : 0 </ul> <ul> par titre : 1 </ul> <ul> par date : 2 </ul> <ul> par Nb d\'episodes : 3 </ul> <ul> par noteMoyenne : 4 </ul> </ol>';
        $html .= '<form id="choix" action = "?action=addChoiceTriCatalogue" method="post">';
        $html .= '<input type="number" name="choixTri" placeholder="0-4" min="0" max="4" > <button type="submit"> Valider </button>';
        $html .= '</form>';
        $html .= '</div>';
        $html .= '<form method="post" action="?action=show-serie-details">';
        $html .= $renderer->render(Renderer::COMPACT);
        $html .= '</form>';
        return $html;
    }
}