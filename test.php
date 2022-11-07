<?php

require_once 'vendor/autoload.php';

$episode = new \netvod\video\Episode("ressources/cars-by-night.mp4", "titre", "resume", 10.00, false);
$episodeRender = new \netvod\render\EpisodeRenderer($episode);
echo $episodeRender->render(2);