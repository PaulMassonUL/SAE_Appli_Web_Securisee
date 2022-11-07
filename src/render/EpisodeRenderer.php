<?php

namespace netvod\render;

use iutnc\deefy\exception\InvalidPropertyNameException;
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

    private function compact()
    {
        // TODO: Implement compact() method.
    }

    /**
     * @throws InvalidPropertyNameException
     */
    public function detail(): string
    {
        return $html = "<div class='episode'>
                      <h3>Titre {$this->episode->__get("titre")}</h3>
                      <h4>Durée {$this->episode->__get("duree")}</h4>
                      <p><u>Résumé de l'épisode : </u><br> {$this->episode->__get("resume")}</p>
                      <video controls> <source src={$this->episode->__get("image")} type='video/mp4'> </video><br>";
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


}