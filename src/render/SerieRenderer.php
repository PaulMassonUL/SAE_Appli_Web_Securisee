<?php

namespace netvod\render;

use netvod\video\Serie;

use netvod\render\EpisodeRenderer;

class SerieRenderer implements Renderer
{
    private Serie $serie;

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
        $html = "<ol>";
        $html .= "<li> <strong> <p> {$this->serie->getTitre()} </p> </strong> <a href = {$this->renderDetail()} /> </li> ";
        $html .= "</ol>";
        return $html;
    }

    public function renderDetail() : string
    {
        $html = "<h1>{$this->serie->titre}</h1>";
        $html .= "<h2>{$this->serie->genre} - {$this->serie->public}</h2>";
        $html .= "<p>$this->serie->descriptif</p>";
        $html .= "<p><<strong>Annee de sortie : </strong>$this->serie->anneeSortie<strong> - Date d ajout : $this->serie->dateAjout</strong>";
        $html .= "<p>Nb episodes :". count($this->serie->getEpisodes())."</p>";

        foreach ($this->serie as $key=>$ep) {
            


        }
        $html .= "</ol>";
        return $html;
    }
}