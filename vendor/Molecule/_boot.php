<?php

function on_shutdown() {
  $err = error_get_last();
  if (!empty($err)) {
    var_dump($err);
  }
}

function require_files($files, $basedir) {
  foreach ($files as $file) {
    require_once "$basedir/$file.php";
  }
}

register_shutdown_function('on_shutdown');

/*
 * Set your default timezone. 
 * @see https://www.php.net/manual/es/function.date-default-timezone-set.php
 */
date_default_timezone_set('America/Argentina/Buenos_Aires');

/*
 * Set your charset. 
 * @see https://www.php.net/manual/es/ini.core.php
 */
ini_set('default_charset', 'UTF-8');

require_files([
    'Request', 'Session', 'HTTP',
    'Webapp', 'DbClient', 'IFirewall',
    'Helper/Date'], __BASEDIR__ . 'vendor/Molecule/');

