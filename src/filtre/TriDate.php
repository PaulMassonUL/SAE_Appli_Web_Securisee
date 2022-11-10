<?php

namespace netvod\filtre;

class TriDate implements Tri
{

    public function filtrer(array $series): array
    {
        usort($series, function ($a, $b) {
            return $a->__get("dateAjout") < $b->__get("dateAjout");
        });
        return $series;
    }
}