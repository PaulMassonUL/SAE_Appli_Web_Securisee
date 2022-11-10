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
        $titre = $this->serie->__get("titre");
        $genre = $this->serie->__get("genre");
        $public = $this->serie->__get("public");
        $descriptif = $this->serie->__get("descriptif");
        $annee = $this->serie->__get("annee");
        $ajout = $this->serie->__get("dateAjout");
        $note = $this->serie->getNoteMoyenne();
        $notee = $this->serie->estNotee();
        $enCours = $this->serie->estEnCours();
        $estPreferee = $this->serie->estPreferee();
        $episodes = $this->serie->__get("episodes");
        $nbEpisodes = count($episodes);
        $commentaires = $this->serie->getCommentaires();
        $commentee = $this->serie->estCommentee();
        $nbCommentaires = count($commentaires);


        $html = <<<END
        <div id="serie">
            <div id="details">
                <div id="title">
                    <div id="title1">
                        <h1>$titre</h1>
        END;
        if ($estPreferee) {
            $html .= <<<END
                <form action="?action=del-serie-fav" method="post">
                    <button class="favbutton" type="submit" name="serieId" value="$id" title="Remove from favories">Remove from favorite</button>
                </form>
            END;
        } else {
            $html .= <<<END
                <form action="?action=add-serie-fav" method="post">
                            <button class="favbutton" type="submit" name="serieId" value="$id" title="Add to favories">Add to favorite</button>
                </form>
            END;
        }
        $html .= <<<END
                    </div>
                    <p>$annee</p>
                </div>
                <div id="description">
                    <p>$descriptif</p>
                </div>
                <div id="info">
                    <div id="genrepublic">
                        <p>Type : $genre</p>
                        <p>Audience : $public</p>
                    </div>
                    <p>Add the : $ajout</p>
                    <p>Average grade : $note / 5 </p>
                </div>
            </div>

            <div id="avis">
                <fieldset>
                    <legend>Grade</legend>
        END;
        if ($notee) {
            $html .= <<<END
                <b>You already rate this series.</b>
            END;
        } else {
            $html .= <<<END
                <form id="note" action="?action=add-serie-note" method="post">
                    <input class="textentry" type="number" min="1" max="5" name="note" placeholder="1 - 5" required>
                    <button type="submit" name="serieId" value="$id">Rate</button>
                </form>
            END;
        }
        $html .= <<<END
                </fieldset>

                <fieldset>
                    <legend>Comment</legend>
        END;
        if ($commentee) {
            $html .= <<<END
                <b>You already comment this series.</b>
            END;
        } else {
            $html .= <<<END
                <form id="commentaire" action="?action=add-serie-comment" method="post">
                    <textarea class="textentry" name = "commentaire" rows = "4" cols = "50" maxlength = "250" placeholder = "Enter a comment" required ></textarea>
                    <button type="submit" name="serieId" value="$id">Comment</button>
                </form>
            END;
        }
        $html .= <<<END
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
            <form method="post" action="?action=show-comments">
                <button id="showComment" type="submit" name="serieId" value="$id" title="Show comments">Show comments</button>
            </form>
        </div>
        END;

        return $html;
    }
}