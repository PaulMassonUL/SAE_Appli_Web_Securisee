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

    public function renderCompact(): string
    {
        return '
            <div class="miniature">
                <div id="view">
                    <img src="' . $this->serie->__get("image") . '" alt="' . $this->serie->__get("image") . '">
                    <label>' . $this->serie->__get("titre") . '</label>
                </div>
                <button id="action" type="submit" name="serieId" value="' . $this->serie->__get("id") . '" title="' . $this->serie->__get("titre") . '"></button>
            </div>
        ';
    }

    public function renderDetail(): string
    {
        $episodes = $this->serie->__get("episodes");
        $nbEpisodes = count($episodes);
        $titre = $this->serie->__get("titre");
        $genre = $this->serie->__get("genre");
        $public = $this->serie->__get("public");
        $descriptif = $this->serie->__get("descriptif");
        $annee = $this->serie->__get("anneeSortie");
        $ajout = $this->serie->__get("dateAjout");

        $html = <<<END
        <div id="serie">
            <div id="serie-details">
                <div id="serie-title">
                    <h1>$titre</h1>
                    <h2>$genre</h2>
                </div>
                <div id="serie-description">
                    <label>$descriptif</label>
                </div>
                <div id="serie-info">
                    <label>Public: $public</label><br>
                    <label>$annee</label><br>
                    <label>Date d'ajout: $ajout</label>
                </div>
            </div>
            
            <div id="notation">
                <br>
                <label> Commentaire : <input type="text" name="commentaire" placeholder="Entrer un commentaire" > </label>
                <br>
                <label> Note : <input type="number" name="note" placeholder="Entrer une note de 1 a 5" > </label>
            </div>
            <div id="serie-episodes">
                <h3>Episodes ($nbEpisodes)</h3>
                <div id="episodes">
                    <ol>
            
        END;

        foreach ($episodes as $num => $episode) {
            $num = $num + 1;
            $html .= "<li><strong>Episode $num</strong>";
            $epRend = new EpisodeRenderer($episode);
            $html .= $epRend->render(Renderer::COMPACT) . "</li><br>";
        }



        $html .= <<<END
                    </ol>
                </div>
            </div>;
        </div>
        END;
        return $html;
    }
}