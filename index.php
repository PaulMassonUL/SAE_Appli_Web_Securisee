<?php

require_once 'vendor/autoload.php';
use netvod\dispatch\Dispatcher_Auth as Dispatcher_Auth;

$dispatch = new Dispatcher_Auth();
$dispatch->run();

