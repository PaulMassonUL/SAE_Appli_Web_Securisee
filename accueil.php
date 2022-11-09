<?php

require_once 'vendor/autoload.php';

use netvod\dispatch\Dispatcher;

if (!isset($_SESSION['user'])) {
    header('Location: index.php');
    exit();
}

\netvod\user\User::setInstance(new \netvod\user\User("mail", "mdp"));

$choixcatalogue = new Dispatcher();
$choixcatalogue->run();
