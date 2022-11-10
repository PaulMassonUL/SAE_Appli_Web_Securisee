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
        $html = '<form id="mots-cles" action = "?action=addMotsCles" method="post">';
        $html .= '<input type="text" name="choixMotsCles" placeholder="key word(s)"> <button type="submit"> Search </button>';
        $html .= '</form>';
        $html .= '<div id="triChoix"> <p> What sort of sort do you want ? : </p> ';
        $html .= '<ol> <ul> By default : 0 </ul> <ul> By title : 1 </ul> <ul> By date : 2 </ul> <ul> By number of episodes : 3 </ul> <ul> by average of note : 4 </ul> </ol>';
        $page = $_SERVER['PHP_SELF'];
        $tri = $this->catalogue->__get("tri");
        $html .= '<form id="choix" action="'.$page.'&tri='.$tri.'" method="post">';
        $html .= '<input type="number" name="choixTri" placeholder="0-4" min="0" max="4" > <button name="btnTri" type="submit"> Validate </button>';
        $html .= '</form>';
        $html .= '</div>';
        if ($this->http_method === 'POST' && isset($_POST['choixTri']) && isset($_POST['btnTri']))
        {
            $tri = intval($_POST['choixTri']);
            $this->catalogue->definirTri($tri);
        }
        else
        {
            $html .= '<form method="post" action="?action=show-serie-details">';
            $html .= $renderer->render(Renderer::COMPACT);
            $html .= '</form>';
        }

        return $html;
    }
}