<?php

namespace netvod\filtre;

class TriTitre implements Tri
{

    public function filtrer(array $series): array
    {
        usort($series, function ($a, $b) {
            return strcmp($a->__get("titre"), $b->__get("titre"));
        });
        return $series;
    }
}