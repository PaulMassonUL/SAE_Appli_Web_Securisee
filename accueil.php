<?php

if (!isset($_SESSION['user'])) {
    header('Location: index.php');
    exit();
}

use netvod\dispatch\Dispatcher;

$choixcatalogue = new Dispatcher();
$choixcatalogue->run();