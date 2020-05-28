<?php

define('__BASEDIR__', dirname(__FILE__) . '/../');

require_once __BASEDIR__ . "vendor/Molecule/_boot.php";


require_files([
    'firewalls/IsAuthenticatedUserFirewall',
    'model/UserRepository',
        ],
        __BASEDIR__ . 'src/');

require_files(['config'],
        __BASEDIR__ . 'env/');


$wa = \Webapp::getInstance();
$wa->basedir = __BASEDIR__ . 'src/';


$wa->addFirewalls([
    'private/' => 'IsAuthenticatedUserFirewall',
]);

$wa->dispatch('public/home');
