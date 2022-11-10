<?php

namespace netvod\filtre;

class TriNormal implements Tri
{

    public function filtrer(array $series): array
    {
        return $series;
    }
}