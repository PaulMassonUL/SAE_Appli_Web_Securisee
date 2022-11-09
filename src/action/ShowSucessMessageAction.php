<?php

namespace netvod\action;

use netvod\video\Serie;

class ShowSucessMessageAction extends Action {

    private string $message;

    public function __construct(string $message) {
        $this->message = $message;
    }

    public function execute(): string
    {
        return "<div id='sucess'><p>$this->message</p></div>";
    }
}