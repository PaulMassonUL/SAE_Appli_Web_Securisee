<?php

namespace netvod\filtre;

class TriNote implements Tri
{

    public function filtrer(array $series): array
    {
        usort($series, function ($a, $b) {
            return $a->getNoteMoyenne() < $b->getNoteMoyenne();
        });
        return $series;
    }
}