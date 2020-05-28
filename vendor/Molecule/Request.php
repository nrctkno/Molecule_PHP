<?php

/**
 * Funciones comunes de app web
 */
class Request {

  public $req_method;
  public $req_params;

  /**
   * @return Webapp
   */
  public function __construct() {
    $this->req_method = $_SERVER['REQUEST_METHOD'];
    $this->req_params = $_REQUEST;
  }

  public function getParam($name, $default = null) {
    if ((array_key_exists($name, $this->req_params)) && !empty($this->req_params[$name])) {
      return $this->req_params[$name];
    } else {
      return $default;
    }
  }

  public function isPost() {
    return $this->req_method == 'POST';
  }

}
