<?php

namespace netvod\filtre;

class TriEpisodes implements Tri
{

    public function filtrer(array $series): array
    {
        usort($series, function ($a, $b) {
            return count($a->__get("episodes")) < count($b->__get("episodes"));
        });
        return $series;
    }
}