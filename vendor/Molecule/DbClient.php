<?php

/**
 * Cliente de bases de datos
 */
class DbClient {

  private static $dbh = null;/** @var \PDO */

  public static function setDBH($dbh) {
    self::$dbh = $dbh;
  }

  /**
   * @return \PDO el objeto cliente
   */
  public static function getDBH() {
    return self::$dbh;
  }

  public static function beginTran() {
    $h = self::getDBH();
//if (!$h->inTransaction()) {
    $h->beginTransaction();
//}
  }

  public static function commitTran() {
    self::$dbh->commit();
  }

  public static function rollbackTran() {
    self::$dbh->rollback();
  }

  /**
   * Ejecuta una consulta
   * @param \String $sql
   * @param \Array $params
   * @param \Int $fetching
   * @return \Array el conjunto resultado completo
   */
  static function query($sql, $params = null, $fetching = \PDO::FETCH_ASSOC) {
    $dbh = self::getDBH(); /* @var $dbh \PDO */
    $stmt = $dbh->prepare($sql); /* @var $stmt \PDOStatement */

    if ($stmt->execute($params)) {
      $result = $stmt->fetchAll($fetching);
      return $result;
    } else {
      throw new \Exception('Error MVC: ' . implode('. ', $stmt->errorInfo()));
    }
  }

  /**
   * Ejecuta una consulta
   * @param \String $sql
   * @param \Array $params
   * @param \Int $fetching
   * @return \Array La primera fila del conjunto resultado
   */
  static function queryOne($sql, $params = null, $fetching = \PDO::FETCH_ASSOC) {
    $rslt = self::query($sql, $params, $fetching);
    return (count($rslt) > 0) ? $rslt[0] : false;
  }

  static function queryScalar($sql, $params = null, $fetching = \PDO::FETCH_ASSOC) {
    $rslt = self::queryOne($sql, $params, $fetching);
    return (count($rslt) > 0) ? array_shift($rslt) : false;
  }

  /**
   * @return \Int
   */
  static function nonQuery($sql, $params = null) {
    $dbh = self::getDBH($sql); /* @var $dbh \PDO */
    $stmt = $dbh->prepare($sql); /* @var $stmt \PDOStatement */
    if ($stmt->execute($params)) {
      return $stmt->rowCount();
    } else {
      throw new \Exception('Error MVC: ' . implode('. ', $stmt->errorInfo()));
    }
  }

  /**
   * Permite depurar una consulta, sustituyendo los placeholders por los parámetros indicados.
   * @param \String $sql
   * @param \Array $params
   * @return \String
   */
  public static function debug($query, $params) {
    $keys = array();
    foreach ($params as $key => $value) {
      if (is_string($key)) {
        $keys[] = '/:' . $key . '/';
      } else {
        $keys[] = '/[?]/';
      }
    }
    $query = preg_replace($keys, $params, $query, 1, $count);
    return $query;
  }

}
