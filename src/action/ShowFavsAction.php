<?php

namespace netvod\action;

use netvod\render\CatalogueRenderer;
use netvod\render\Renderer;

class ShowFavsAction extends Action
{

    public function execute(): string
    {
        $user = $_SESSION['user'];
        $catalogue = $user->getSeriesPref();
        $renderer = new CatalogueRenderer($catalogue);
        return $renderer->render(Renderer::COMPACT);
    }

}