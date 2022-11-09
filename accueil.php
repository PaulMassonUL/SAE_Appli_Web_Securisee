<?php

session_start();

require_once 'vendor/autoload.php';

use netvod\dispatch\Dispatcher;

if (!isset($_SESSION['user'])) {
    header('Location: index.php');
    exit();
}

$choixcatalogue = new Dispatcher();
$choixcatalogue->run();
