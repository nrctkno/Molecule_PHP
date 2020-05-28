<?php

class Replacer {

  static $months = Array(
      "Enero" => "01",
      "Febrero" => "02",
      "Marzo" => "03",
      "Abril" => "04",
      "Mayo" => "05",
      "Junio" => "06",
      "Julio" => "07",
      "Agosto" => "08",
      "Septiembre" => "09",
      "Octubre" => "10",
      "Noviembre" => "11",
      "Diciembre" => "12"
  );

  public static function getMonthNumber($name) {
    return self::$months[$name];
  }

  public static function replace($string, $array) {
    $len = count($array);
    for ($i = 0; $i < $len; $i++) {
      $string = str_replace('[' . $i . ']', Replacer::parse($array[$i]), $string);
    }
    return $string;
  }

  public static function parse($string) {
    //sanitizar
    $string = str_replace("'", "´", $string);

    //es datetime?
    $d = DateTime::createFromFormat('d/m/Y H:i:s', $string);
    if ($d) {
      return $d->format('Y-m-d H:i:s');
    }
    //o es date?
    $d = DateTime::createFromFormat('d/m/Y', $string);
    if ($d) {
      return $d->format('Y-m-d H:i:s');
    }

    //es mes escrito?
    if (isset(Replacer::$months[$string])) {
      return Replacer::$months[$string];
    }
    //no es ninguno de los anteriores
    return $string;
  }

}
