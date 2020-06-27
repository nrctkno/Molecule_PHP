<?php

define('__BASEDIR__', dirname(__FILE__) . '/../');

require_once __BASEDIR__ . "vendor/Molecule/_boot.php";


require_files([
    'firewalls/IsAuthenticatedUserFirewall',
    'firewalls/HasCSRFTokenFirewall',
    'model/UserRepository',
        ],
        __BASEDIR__ . 'src/');

require_files(['config'],
        __BASEDIR__ . 'env/');


$wa = \Webapp::getInstance();

$wa->basedir = __BASEDIR__ ;

$wa->addFirewall('private/', 'IsAuthenticatedUserFirewall')
   ->addFirewall('', 'HasCSRFTokenFirewall');

$wa->dispatch('public/home');
