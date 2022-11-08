<?php

namespace netvod\render;

use netvod\video\Serie;

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
        }
        return $html;
    }

    public function renderCompact() : string
    {
        $html = '<a href="serie.php?id='.$this->serie->__get("id").'">
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
        $html = "<h1>{$this->serie->__get("titre")}</h1>";
        $html .= "<h2>{$this->serie->__get("genre")} - {$this->serie->__get("public")}</h2>";
        $html .= "<p>{$this->serie->__get("descriptif")}</p>";
        $html .= "<p><strong>Annee de sortie : </strong>{$this->serie->__get("anneeSortie")}<strong> - Date d'ajout : {$this->serie->__get("dateAjout")}</strong>";
        $html .= "<p>Nb episodes : ". count($this->serie->__get("episodes"))."</p>";
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