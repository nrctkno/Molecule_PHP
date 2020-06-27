<?php

/**
 * Funciones comunes de app web
 */
class Webapp {

  public static $instance;
  public $basedir;
  public $baseuri;

  /** @var \Request */
  public $request;

  /** @var \Session */
  public $session;

  /** @var \Session */
  public $globals;

  /** @var Array */
  private $firewalls;

  /**
   * @return Webapp
   */
  public static function getInstance() {
    if (empty(self::$instance)) {
      self::$instance = new self();
      self::$instance->init();
    }

    return self::$instance;
  }

  public function init() {
    $subdir = str_replace('?' . $_SERVER['QUERY_STRING'], '', $_SERVER['REQUEST_URI']);

    $this->baseuri = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]" . $subdir;
    $this->request = new Request();
    $this->session = new Session();
    $this->globals = [];
    $this->firewalls = [];
  }

  public function setGlobal($name, $value) {
    $this->globals[$name] = $value;
  }

  public function getGlobal($name) {
    return $this->globals[$name];
  }

  public function removeGlobal($name) {
    unset($this->globals[$name]);
  }

  public function route($action, $params = []) {
    $pairs = [];
    foreach ($params as $k => $v) {
      $pairs[] = $k . '=' . urlencode($v);
    }

    if (count($pairs) > 0) {
      $params = '&' . join('&', $pairs);
    } else {
      $params = '';
    }
    return $this->baseuri . "?mcl_a=$action" . $params;
  }

  public function view_import($view, $vars = []) {
    include $this->basedir . 'src/views/' . $view;
  }

  public function addFirewall($path, $firewall) {
    $this->firewalls[$path] = $firewall;

    return $this;
  }

  public function checkFirewalls($action) {
    foreach ($this->firewalls as $path => $firewall) {
      if (substr($action, 0, strlen($path)) === $path) {
        $f = new $firewall();

        if (array_search($action, $f->getExcluded()) !== false) {
          return;
        }

        $f->execute($this);
      }
    }
  }

  public function dispatch($default_action) {
    $a = $this->request->getParam('mcl_a', $default_action);

    $this->checkFirewalls($a);

    include_once $this->basedir . "src/actions/$a.php";
  }

  public function respondRedirect($action, $params = []) {
    header("Location: " . $this->route($action, $params));
    die();
  }

  public function respondStatus($status, $content = '') {
    header(\HTTP::getHeader($status));
    echo $content;
    die();
  }

  public function respondJSON($content, $status = 200) {
    header(\HTTP::getHeader($status));
    header('Content-Type: application/json');
    echo json_encode($content);
    die();
  }

}
