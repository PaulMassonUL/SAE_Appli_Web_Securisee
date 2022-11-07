<?php

namespace netvod\render;

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

    public function detail(): string
    {
        return $html = "<div class='episode'>
                      <h3>Titre {$this->episode->getTitre()}</h3>
                      <h4>Durée {$this->episode->getDuree()}</h4>
                      <p><u>Résumé de l'épisode : </u><br> {$this->episode->getResume()}</p>
                      <video src={$this->episode->getImage()}><br>";
    }

    public function render(int $selector): string
    {
        $html = "";
        switch ($selector) {
            case Renderer::COMPACT:
                $html = $this->compact();
                break;
            case Renderer::DETAIL:
                $html = $this->detail();
                break;
        }
        return $html;
    }

    private function compact()
    {
        // TODO: Implement compact() method.
    }
}