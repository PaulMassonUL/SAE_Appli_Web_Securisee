<?php

namespace netvod\action;

use netvod\render\EpisodeRenderer;
use netvod\render\Renderer;
use netvod\render\SerieRenderer;
use netvod\user\User;
use netvod\video\Episode;
use netvod\video\Serie;

class ShowEpisodeAction extends Action
{
    private Serie $serie;
    private Episode $episode;

    /**
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
     * @throws \netvod\exception\InvalidPropertyNameException
     */
    public function execute(): string
    {
        $user = unserialize($_SESSION['user']);
        $user->ajouterSerieEnCours($this->serie);
        $renderer = new EpisodeRenderer($this->episode);
        return $renderer->render(Renderer::DETAIL);
    }
}