<?php

namespace netvod\action;

use netvod\video\Serie;

class ShowSerieSucessAction extends Action {

    private Serie $serie;

    private string $message;

    public function __construct(Serie $serie, string $message) {
        $this->serie = $serie;
        $this->message = $message;
        parent::__construct();
    }

    public function execute(): string
    {
        return <<<END
            <div id="sucess">
                <label>$this->message</label>
                <form action="?action=show-serie-details" method="post">
                    <input type="hidden" name="serieId" value="{$this->serie->__get("id")}">
                    <input id="return" type="submit" value="Return to serie">
                </form>
            </div>
        END;
    }
}