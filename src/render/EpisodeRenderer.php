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

    private function compact()
    {
        return '<button type=\"submit name=episodeId value="' . $this->episode->__get("numero") .'">
            <div class=\'episode\'>
                 <h2>Titre : {$this->episode->__get("titre")}</h2>
                 <h3>Durée : {$this->episode->__get("duree")} minutes</h3>
                <video controls> <source src={$this->episode->__get("image")} type='video/mp4'> </video><br>;
                </button>';

    }

    /**
     * @throws InvalidPropertyNameException
     */
    public function detail(): string
    {
        return $html = "<div class='episode'>
                      <h2>Titre : {$this->episode->__get("titre")}</h2>
                      <h3>Durée : {$this->episode->__get("duree")} minutes</h3>
                      <p><u id='TitreParagraphe'>Résumé de l'épisode : </u><br> {$this->episode->__get("resume")}</p>
                      <video controls> <source src={$this->episode->__get("image")} type='video/mp4'> </video><br>";

    }


    public function render(int $selector): string
    {
        $html = "";
        switch ($selector) {
            case Renderer::COMPACT:
                $html = $this->Compact();
                break;
            case Renderer::DETAIL:
                $html = $this->Detail();
                break;
        }
        return $html;
    }


}