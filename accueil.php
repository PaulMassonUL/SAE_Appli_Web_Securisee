<?php

if (!isset($_SESSION['user'])) {
    header('Location: index.php');
    exit();
}

use netvod\dispatch\Dispatcher;

echo "accueil";
$choixcatalogue = new Dispatcher();
$choixcatalogue->run();