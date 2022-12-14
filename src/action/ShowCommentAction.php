<?php

namespace netvod\action;

use netvod\video\Serie;

class ShowCommentAction extends Action {

    private Serie $serie;

    private array $commentaires;


    public function __construct(Serie $serie, array $commentaires)
    {
        $this->serie = $serie;
        $this->commentaires = $commentaires;
        parent::__construct();
    }

    public function execute(): string
    {
        $html = '<div id="comm">
        <label> Comments of : ' . $this->serie->__get('titre') . '</label></br>';

        //email=>commentaire
        if (count($this->commentaires) > 0) {
            $html .= '<div id="listcomm">';
            foreach ($this->commentaires as $key => $com) {
                $html .= '<p>' . $key . ' : ' . $com . '</p></br>';
            }
            $html .= '</div>';
        } else {
            $html .= 'Pas de commentaire pour le moment';
        }

        $html .= '
                <form action="?action=show-serie-details" method="post">
                    <input type="hidden" name="serieId" value="' . $this->serie->__get("id") . '">
                    <input id="return" type="submit" value="Return to serie">
                </form>
            </div> ';

            return $html;

    }


}