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

    private function rendercompact()
    {
        return $html = "<div class='episode'>
                      <h2>Titre : {$this->episode->__get("titre")}</h2>
                      <h3>Durée : {$this->episode->__get("duree")} minutes</h3>
                      <p><u id='TitreParagraphe'>Résumé de l'épisode : </u><br> {$this->episode->__get("resume")}</p>
                      <video controls> <source src={$this->episode->__get("image")} type='video/mp4'> </video><br>";
    }

    /**
     * @throws InvalidPropertyNameException
     */
    public function renderdetail(): string
    {

    }


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