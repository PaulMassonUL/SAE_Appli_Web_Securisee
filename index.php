<?php

session_start();

require_once 'vendor/autoload.php';

use netvod\dispatch\Dispatcher_Auth;

$dispatch = new Dispatcher_Auth();
$dispatch->run();

