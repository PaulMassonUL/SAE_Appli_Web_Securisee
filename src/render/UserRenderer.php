<?php

namespace netvod\render;

use netvod\exception\InvalidPropertyNameException;
use netvod\user\User;

class UserRenderer implements Renderer
{
    /**
     * @var User $user
     */
    private User $user;

    /**
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * @return string
     * @throws InvalidPropertyNameException
     */
    private function renderCompact(): string
    {
        if ($this->user->__get("prenom") != '' && $this->user->__get("nom") != '') {
            return $this->user->__get("prenom") . " " . $this->user->__get("nom");
        }
        return $this->user->__get("email");
    }

    /**
     * @throws InvalidPropertyNameException
     */
    public function renderDetail(): string
    {

        $html = <<<END
            <br>
            <label id="title">Prénom</label>
            <br>
            <input type="text" name="prenom" maxlength="128" value="{$this->user->__get("prenom")}">
            <br><br>
            <label id="title">Nom</label>
            <br>
            <input type="text" name="nom" maxlength="128" value="{$this->user->__get("nom")}">
            <br><br>
            <label id="title">Age</label>
            <br>
            <input type="number" min="1" name="age" value="{$this->user->__get("age")}">
            <br><br>
            <label id="title">Genre Préféré</label>
            <br>
            <input type="text" name="genrePref" maxlength="128" value="{$this->user->__get("genrePref")}">
            <br><br>
            <input id="return" type="submit" value="Validate the informations">

        END;

        return $html;
    }

    /**
     * @throws InvalidPropertyNameException
     */
    public function render(int $selector): string
    {
        $html = "";
        switch ($selector) {
            case Renderer::COMPACT:
                $html = $this->renderCompact();
                break;
            case Renderer::DETAIL:
                $html = $this->renderDetail();
                break;
        }
        return $html;
    }
}