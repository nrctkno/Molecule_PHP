<?php

/**
 * Funciones de sesión
 */
class Session {

  const fb_id = 'flashbag';
  const csrf_id = 'csrf_token';

  public function __construct() {
    session_start();
  }

  public function addFlash($type, $value) {
    if (!array_key_exists(self::fb_id, $_SESSION)) {
      $_SESSION[self::fb_id] = [];
    }
    if (!array_key_exists($type, $_SESSION[self::fb_id])) {
      $_SESSION[self::fb_id][$type] = [];
    }
    array_push($_SESSION[self::fb_id][$type], $value);
  }

  public function hasFlash($type) {
    return
            array_key_exists(self::fb_id, $_SESSION) &&
            array_key_exists($type, $_SESSION[self::fb_id]);
  }

  public function getFlash($type) {
    if (array_key_exists($type, $_SESSION[self::fb_id])) {
      $value = $_SESSION[self::fb_id][$type];
      unset($_SESSION[self::fb_id][$type]);
      return $value;
    }
    return null;
  }

  public function setVar($name, $value) {
    $_SESSION[$name] = $value;
  }

  public function hasVar($name) {
    return array_key_exists($name, $_SESSION);
  }

  public function getVar($name) {
    if (array_key_exists($name, $_SESSION)) {
      return $_SESSION[$name];
    }
    return null;
  }

  public function removeVar($name) {
    unset($_SESSION[$name]);
  }

  public function getCSRFId() {
    return self::csrf_id;
  }

  public function getCSRFToken() {
    if (empty($_SESSION[self::csrf_id])) {
      $_SESSION[self::csrf_id] = bin2hex(random_bytes(32));
    }
    return $_SESSION[self::csrf_id];
  }

  public function CSRFTokenInput() {
    $token = $this->getCSRFToken();
    return '<input type="hidden" name="' . self::csrf_id . '" value="' . $token . '">';
  }

}
