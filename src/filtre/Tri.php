<?php

namespace netvod\filtre;

interface Tri
{
    const FILTRE_NORMAL = 0;
    const FILTRE_TITRE = 1;
    const FILTRE_DATE = 2;
    const FILTRE_EPISODES = 3;
    const FILTRE_NOTE = 4;

    public function filtrer(array $series): array;
}