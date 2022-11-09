<?php

namespace netvod\action;

use netvod\user\User;

class AddToFavAction extends Action
{
    private User $user;

    /**
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
        parent::__construct();
    }


    public function execute(): string
    {
        // TODO: Implement execute() method.
    }
}