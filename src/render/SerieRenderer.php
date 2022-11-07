<?php

namespace netvod\render;

use netvod\video\Serie;

use netvod\render\EpisodeRenderer;

class SerieRenderer implements Renderer
{
    private Serie $serie;

    function __construct($serie)
    {
        $this->serie = $serie;
    }

    public function render(int $selector): string
    {
        $html = "";
        switch ($selector) {
            case Renderer::COMPACT :
                $html = $this->renderCompact();
                break;
            case Renderer::DETAIL :
                $html = $this->renderDetail();
                break;
            default:
                throw new \Exception("erreur de parametre");
        }
        return $html;
    }

    public function renderCompact() : string
    {
        $html = '<a href="nouvellepage?serie=">
            <div>
                <p>'.$this->serie->__get("titre").'</p>
                <img src="'.$this->serie->getImage().'">
                <p>'.$this->serie->__get("duree").'</p>
            </div>
        </a>';

        return $html;
    }

    public function renderDetail() : string
    {
        $html = "<h1>{$this->serie->getTitre()}</h1>";
        $html .= "<h2>{$this->serie->getGenre()} - {$this->serie->getPublic()}</h2>";
        $html .= "<p>$this->serie->getDescriptif()</p>";
        $html .= "<p><strong>Annee de sortie : </strong>$this->serie->getAnneeSortie()<strong> - Date d ajout : $this->serie->getDateAjout()</strong>";
        $html .= "<p>Nb episodes :". count($this->serie->getEpisodes())."</p>";

       $html .= "<ol>";
        foreach ($this->serie as $key=>$ep) {
            $html .= "<li><strong>Episode $key</strong>";
            $epRend = new EpisodeRenderer($ep);
            $html .= "{$epRend->render(Renderer::DETAIL)}</li>";
        }
        $html .= "</ol>";
        return $html;
    }
}