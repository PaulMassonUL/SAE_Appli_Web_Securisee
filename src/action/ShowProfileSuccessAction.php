<?php

namespace netvod\action;

class ShowProfileSuccessAction extends Action {

    private string $message;

    public function __construct(string $message) {
        $this->message = $message;
        parent::__construct();
    }

    public function execute(): string
    {
        return <<<END
            <div id="sucess">
                <label>$this->message</label>
                <form action="accueil.php">
                    <input id="return" type="submit" value="Return to home">
                </form>
            </div>
        END;
    }
}