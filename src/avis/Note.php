<?php

namespace netvod\avis;

class Note
{
    private float $moyenne;
    private int $nbNotes;

    public function __construct()
    {

    }

    public function ajouterNote(float $note) : void
    {
        $this->nbNotes++;
        $this->moyenne += $note / $this->nbNotes;
    }
}