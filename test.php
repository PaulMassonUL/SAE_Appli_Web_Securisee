<?php

require_once 'vendor/autoload.php';

$serie1 = new \netvod\video\Serie(1,"Une série cool","ressources/beach.mp4","horreur","adulte","vraiment une série trop cool",2020,"01/03/2021");
$serie2 = new \netvod\video\Serie(2, "Une série encore plus cool", "ressources/cars-by-night.mp4", "fantaisie", "ado", "trop bien", 2016, "06/05/2016");

$text = "Maecenas at mattis dolor, ac egestas ex. Maecenas accumsan libero a euismod ullamcorper. Duis maximus purus in velit dapibus volutpat. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Nunc sit amet pretium nulla, nec lacinia mauris. Aenean ut accumsan justo. Vestibulum at sapien dapibus, dignissim diam sed, maximus diam. Nam semper fringilla justo ac consequat. Suspendisse auctor in eros sed lobortis. Donec efficitur eleifend ante id tempus.";

$episode1 = new \netvod\video\Episode(1,"ressources/cars-by-night.mp4", "fast And furious", $text, "0:27", false);
$episodeRender1 = new \netvod\render\EpisodeRenderer($episode1);

$episode2 = new \netvod\video\Episode(2,"ressources/beach.mp4", "Les dents de la mer", $text, "0:17", false);
$episodeRender2 = new \netvod\render\EpisodeRenderer($episode2);

$episode3 = new \netvod\video\Episode(3, "ressources/horses.mp4", "Des cheveaux", $text, "0:07", false);
$episodeRender3 = new \netvod\render\EpisodeRenderer($episode3);

$episode4 = new \netvod\video\Episode(4, "ressources/lake.mp4", "Un lac", $text, "0:08", false);
$episodeRender4 = new \netvod\render\EpisodeRenderer($episode4);

$serie1->ajouterEpisode($episode1);
$serie1->ajouterEpisode($episode2);

$serie2->ajouterEpisode($episode3);
$serie2->ajouterEpisode($episode4);

$serieRender1 = new \netvod\render\SerieRenderer($serie1);
echo $serieRender1->render(2);
$serieRender2 = new \netvod\render\SerieRenderer($serie2);
echo $serieRender2->render(2);

$series = array($serie1,$serie2);

$catalogue = new \netvod\video\Catalogue($series);
$catalogueRender = new \netvod\render\CatalogueRenderer($catalogue);
echo $catalogueRender->render(1);
