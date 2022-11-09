<?php

namespace netvod\action;

use netvod\exception\InvalidPropertyNameException;
use netvod\render\EpisodeRenderer;
use netvod\render\Renderer;
use netvod\video\Episode;
use netvod\video\Serie;

class ShowEpisodeAction extends Action
{
    /**
     * @var Serie
     */
    private Serie $serie;
    /**
     * @var Episode
     */
    private Episode $episode;

    /**
     * @param Serie $serie
     * @param Episode $episode
     */
    public function __construct(Serie $serie, Episode $episode)
    {
        $this->serie = $serie;
        $this->episode = $episode;
        parent::__construct();
    }

    /**
     * @return string correspondant au rendu sur le site
     * @throws InvalidPropertyNameException
     */
    public function execute(): string
    {
        $user = unserialize($_SESSION['user']);
        $user->voirEpisode($this->episode);
        $renderer = new EpisodeRenderer($this->episode);
        return $renderer->render(Renderer::DETAIL);
    }
}