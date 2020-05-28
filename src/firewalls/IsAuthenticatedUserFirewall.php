<?php

class IsAuthenticatedUserFirewall implements IFirewall {

  public function execute(Webapp $app) {
    $user = $app->session->getVar('user');

    if (empty($user)) {
      $app->session->addFlash('info', 'Please login to access the private section');
      $app->respondRedirect('public/login');
    }
  }

  public function getExcluded() {
    return [
            //'private/login',
    ];
  }

}
