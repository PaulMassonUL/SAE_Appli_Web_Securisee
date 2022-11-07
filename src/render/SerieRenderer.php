<?php

namespace netvod\render;

class SerieRenderer implements Renderer
{
    private Serie $serie;

    public function render(int $selector): string
    {
        switch ($selector) {
            case 1 :
                $this->renderCompact();
                break;
            case 2 :
                $this->renderDetail();
                break;
            default:
                throw new \Exception("erreur de parametre");
        }
    }

    public function renderCompact() : string
    {
        $html = "<ol>";
        $html .= "<li><strong><a href = ""$this->serie->titre";
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

    }
}