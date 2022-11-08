<?php

namespace netvod\action;

use netvod\render\Renderer;
use netvod\render\SerieRenderer;
use netvod\video\Episode;
use netvod\video\Serie;

class ShowEpisodeAction extends Action
{
    private Episode $episode;

    /**
     * @param Episode $episode
     */
    public function __construct(Episode $episode)
    {
        $this->episode = $episode;
        parent::__construct();
    }

    public function execute(): string
    {
        $renderer = new EpisodeRenderer($this->episode);
        return $renderer->render(Renderer::DETAIL);
    }
}