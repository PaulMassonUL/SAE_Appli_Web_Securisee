<?php

require_once 'vendor/autoload.php';

/**$serie = new \netvod\video\Serie("titre","ressources/beach.mp4","genre","public","ok",2020,"01/03/2021");
$serieRender = new \netvod\render\SerieRenderer($serie);
echo $serieRender->render(2);*/


$text = "Maecenas at mattis dolor, ac egestas ex. Maecenas accumsan libero a euismod ullamcorper. Duis maximus purus in velit dapibus volutpat. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Nunc sit amet pretium nulla, nec lacinia mauris. Aenean ut accumsan justo. Vestibulum at sapien dapibus, dignissim diam sed, maximus diam. Nam semper fringilla justo ac consequat. Suspendisse auctor in eros sed lobortis. Donec efficitur eleifend ante id tempus.";

$episode1 = new \netvod\video\Episode(1,"ressources/cars-by-night.mp4", "titre", $text, 10.57, false);
$episodeRender1 = new \netvod\render\EpisodeRenderer($episode1);
echo $episodeRender1->render(2);

$episode2 = new \netvod\video\Episode(2,"ressources/beach.mp4", "titre", $text, 10.82, false);
$episodeRender2 = new \netvod\render\EpisodeRenderer($episode2);
echo $episodeRender2->render(2);