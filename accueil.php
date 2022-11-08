<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<header id="header">
    <nav id="nav">
        <a id="title" href="accueil.php">NetVOD</a>
        <a href="?action=browse">Catalogue</a>
        <a href="?action=show-favorites">Favoris</a>
    </nav>
    <a id="logout" href="?action=logout">
        <button>LOGOUT</button>
    </a>
</header>
</body>
</html>

<?php

require_once 'vendor/autoload.php';

use netvod\dispatch\Dispatcher;

//if (!isset($_SESSION['user'])) {
//    header('Location: index.php');
//    exit();
//}

\netvod\user\User::setInstance(new \netvod\user\User("mail", "mdp"));

$choixcatalogue = new Dispatcher();
$choixcatalogue->run();
