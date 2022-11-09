<?php

namespace netvod\render;

use netvod\exception\InvalidPropertyNameException;
use netvod\video\Episode;

class EpisodeRenderer implements Renderer
{
    /**
     * @var Episode $episode
     */
    private Episode $episode;

    /**
     * @param Episode $episode
     */
    public function __construct(Episode $episode)
    {
        $this->episode = $episode;
    }

    /**
     * @return string
     * @throws InvalidPropertyNameException
     */
    private function renderCompact() : string
    {
        return '<br><button type="submit" name="numEpisode" value="' . $this->episode->__get("numero") .'">
            <h2>' . $this->episode->__get("titre") . '</h2>
            <h3>' . $this->episode->__get("duree") .'</h3>
            <img src="' . $this->episode->__get("image") . '" alt="' . $this->episode->__get("titre") . '">
        </button>';

    }

    /**
     * @throws InvalidPropertyNameException
     */
    public function renderDetail(): string
    {
        $html = "<div class='episode'>
                      <h2>Titre : {$this->episode->__get("titre")}</h2>
                      <h3>Durée : {$this->episode->__get("duree")} minutes</h3>
                      <p><u id='TitreParagraphe'>Résumé de l'épisode : </u><br> {$this->episode->__get("resume")}</p>
                      <video controls> <source src={$this->episode->__get("image")} type='video/mp4'> </video><br>
                 </div>";
        $html .= '<br><button type="submit" name="addFav" value="Add to favorite"></button>';
        return $html;

    }

    /**
     * @throws InvalidPropertyNameException
     */
    public function render(int $selector): string
    {
        $html = "";
        switch ($selector) {
            case Renderer::COMPACT:
                $html = $this->renderCompact();
                break;
            case Renderer::DETAIL:
                $html = $this->renderDetail();
                break;
        }
        return $html;
    }
}