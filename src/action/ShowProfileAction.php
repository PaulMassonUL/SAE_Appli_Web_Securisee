<?php

namespace netvod\action;

use netvod\exception\InvalidPropertyNameException;
use netvod\render\Renderer;
use netvod\render\UserRenderer;
use netvod\user\User;

class ShowProfileAction extends Action
{

    /**
     * @var User
     */
    private User $user;

    /**
     * @param User $user
     * Constructeur paramétré
     */
    public function __construct(User $user)
    {
        $this->user = $user;
        parent::__construct();
    }

    /**
     * @return string
     * execute l'action
     * @throws InvalidPropertyNameException
     */
    public function execute(): string
    {
        $renderer = new UserRenderer($this->user);

        $html = '<form method="post" action="?action=update-profile">';
        $html .= $renderer->render(Renderer::DETAIL);
        $html .= '</form>';
        return $html;
    }
}