<?php

namespace Molecule\Helper;

class Date {

  public static function fromFormat($str, $informat, $outformat) {
    $d = \DateTime::createFromFormat($informat, $str);
    if ($d) {
      return $d->format($outformat);
    }
    return null;
  }

  public static function fromANSI($str, $outfmt, $time = true) {
    return self::fromFormat($str, self::getANSIFormat($time), $outfmt);
  }

  public static function toANSI($str, $informat, $time = true) {

    return self::fromFormat($str, $informat, self::getANSIFormat($time));
  }

  public static function createPrev($outfmt, $interval = null) {
    $d = new \DateTime();
    $d->sub(new \DateInterval($interval));
    return $d->format($outfmt);
  }

  private static function getANSIFormat($time = true) {
    $fmt = 'Y-m-d';
    if ($time) {
      $fmt .= ' H:i:s';
    }
    return $fmt;
  }

}
