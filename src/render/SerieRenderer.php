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
<form method="post" action="?action=add-serie-fav">
                        <button id="favoris" type="submit" name="serieId2" value="' . $this->serie->__get("id") .'" title="Ajouter aux favoris"></button>
                    </form><br>
            <div class="miniature">
                <div id="view">
                    <img src="' . "ressources/" . $this->serie->__get("image") . '" alt="' . $this->serie->__get("image") . '">
                    <label>' . $this->serie->__get("titre") . '</label>
                </div>
                <button id="action" type="submit" name="serieId" value="' . $this->serie->__get("id") . '" title="' . $this->serie->__get("titre") . '"></button>
                
            

            </div>
        ';
    }

    public function renderDetail(): string
    {
        $id = $this->serie->__get("id");
        $episodes = $this->serie->__get("episodes");
        $nbEpisodes = count($episodes);
        $titre = $this->serie->__get("titre");
        $genre = $this->serie->__get("genres");
        $public = $this->serie->__get("publics");
        $descriptif = $this->serie->__get("descriptif");
        $annee = $this->serie->__get("annee");
        $ajout = $this->serie->__get("dateAjout");

        $html = <<<END
        <div id="serie">
            <div id="serie-details">
                <div id="serie-title">
             
                    <h1>$titre</h1>
                    <h2>$genre[0]</h2>
                </div>
                <div id="serie-description">
                    <label>$descriptif</label>
                </div>
                <div id="serie-info">
                    <label>Public: $public[0]</label><br>
                    <label>$annee</label><br>
                    <label>Date d'ajout: $ajout</label>
                </div>
            </div>
            
            <br>
            <fieldset>
                <legend>Note</legend>
                <form id="note" action="." method="post">
                    <input type="number" min="1" max="5" name="note" placeholder="1 - 5" required>
                    <input type="submit" name="noter" value="Noter">
                </form>
            </fieldset>
            
            <fieldset>
                <legend>Commentaire</legend>
                <form id="commentaire" action="." method="post">
                    <textarea name="commentaire" rows="4" cols="60" maxlength="250" placeholder="Entrer un commentaire" required></textarea>
                    <input type="submit" name="commenter" value="Commenter">
                </form>
            </fieldset>
            
            <form method="post" action="?action=show-episode-details">
                <input type="hidden" name="serieId" value="$id">
                <h3><label>Episodes ($nbEpisodes)</label></h3>
                <div id="episodes">
                    <menu>
            
        END;

        foreach ($episodes as $num => $episode) {
            $num = $num + 1;
            $html .= "<li>Episode $num";
            $epRend = new EpisodeRenderer($episode);
            $html .= $epRend->render(Renderer::COMPACT) . "</li><br>";
        }


        $html .= <<<END
                    </menu>
                </div>
            </form>
        </div>
        END;
        return $html;
    }
}