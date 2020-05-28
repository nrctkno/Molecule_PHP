<?php

$wa = \Webapp::getInstance();

if ($wa->session->hasVar('user') && ($wa->session->getVar('user') !== false)) {
  $wa->session->removeVar('user');

  $wa->session->addFlash('info', 'Logout successful.');

  return $wa->respondRedirect('public/home');
}

//this action does not require any HTML