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
        $genre = $this->serie->__get("genre");
        $public = $this->serie->__get("public");
        $descriptif = $this->serie->__get("descriptif");
        $annee = $this->serie->__get("annee");
        $ajout = $this->serie->__get("dateAjout");

        $html = <<<END
        <div id="serie">
            <div id="details">
                <div id="title">
                    <h1>$titre</h1>
                    <form action="?action=add-serie-fav" method="post">
                        <button id="favoris" type="submit" name="serieId" value="$id" title="Ajouter aux favoris">Add to favorite</button>
                    </form>
                    <h3>$annee</h3>
                </div>
                <div id="description">
                    <p>$descriptif</p>
                </div>
                <div id="info">
                    <h3>Genre : $genre</h3>
                    <h3>Public : $public</h3>
                    <p>Date d'ajout: $ajout</p>
                </div>
            </div>
            
            <br>
            <div id="avis">
                <fieldset>
                    <legend>Note</legend>
                    <form id="note" action="?action=add-serie-note" method="post">
                        <input type="number" min="1" max="5" name="note" placeholder="1 - 5" required>
                        <input type="submit" name="noter" value="Noter">
                    </form>
                </fieldset>
                
                <fieldset>
                    <legend>Commentaire</legend>
                    <form id="commentaire" action="?action=add-serie-comment" method="post">
                        <textarea name="commentaire" rows="4" cols="60" maxlength="250" placeholder="Entrer un commentaire" required></textarea>
                        <input type="submit" name="commenter" value="Commenter">
                    </form>
                </fieldset>
            </div>
            
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