<?php

require_once 'vendor/autoload.php';
use netvod\dispatch\Dispatcher_Auth as Dispatcher_Auth;

$dispatch = new Dispatcher_Auth();
$dispatch->run();

$episode = new \netvod\video\Episode("ressources/beach.mp4","titre","resume",10.00,false);
$episodeRender = new \netvod\render\EpisodeRenderer($episode);
echo $episodeRender->render(2);