<?php

namespace netvod\action;

use Exception;
use netvod\exception\InvalidPropertyNameException;
use netvod\render\EpisodeRenderer;
use netvod\render\Renderer;
use netvod\video\Episode;

class ShowEpisodeAction extends Action
{
    /**
     * @var Episode
     */
    private Episode $episode;

    /**
     * @param Episode $episode
     */
    public function __construct(Episode $episode)
    {
        $this->episode = $episode;
        parent::__construct();
    }

    /**
     * @return string correspondant au rendu sur le site
     * @throws InvalidPropertyNameException
     */
    public function execute(): string
    {
        $this->episode->marquerCommeVu();
        $renderer = new EpisodeRenderer($this->episode);
        return $renderer->render(Renderer::DETAIL);
    }
}