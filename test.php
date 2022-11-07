<?php

require_once 'vendor/autoload.php';

$episode1 = new \netvod\video\Episode("ressources/cars-by-night.mp4", "titre", "resume", 10.00, false);
$episodeRender1 = new \netvod\render\EpisodeRenderer($episode1);
echo $episodeRender1->render(2);

$episode2 = new \netvod\video\Episode("ressources/beach.mp4", "titre", "resume", 10.00, false);
$episodeRender2 = new \netvod\render\EpisodeRenderer($episode2);
echo $episodeRender2->render(2);