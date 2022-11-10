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
    private function renderCompact(): string
    {
        return '<br><button id="buttonFav" type="submit" name="idEpisode" value="' . $this->episode->__get("id") . '">
            <h2>' . $this->episode->__get("titre") . '</h2>
            <h3>' . $this->episode->__get("duree") . ' minutes</h3>
        </button>';

    }

    /**
     * @throws InvalidPropertyNameException
     */
    public function renderDetail(): string
    {
        $ressources = "ressources/" . $this->episode->__get("fichier");
        return "<div class='episode'>
                      <h2>Title : {$this->episode->__get("titre")}</h2>
                      <h3>Length : {$this->episode->__get("duree")} minutes</h3>
                      <p><u id='TitreParagraphe'>Summary : </u><br> {$this->episode->__get("resume")}</p>
                      <video controls> <source src={$ressources} type='video/mp4'> </video><br>
                 </div>";

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