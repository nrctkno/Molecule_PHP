<?php

class HasCSRFTokenFirewall implements IFirewall {

  public function execute($app) {

    $csrf_id = $app->session->getCSRFId();

    $server_token = $app->session->getCSRFToken();
    $client_token = $app->request->getParam($csrf_id);

    if (is_null($client_token)) {
      return;
    }

    if (!empty($client_token)) {
      if (!hash_equals($client_token, $server_token)) {
        throw new Exception('Invalid CSRF token');
      }
    }
  }

  public function getExcluded() {
    return []; //no necesita excluir URLs porque se aplica a todo el sitio
  }

}
