<?php

namespace App\Http;

class Helpers {
  public static function greeting()
  {
    $hoursNow = now()->format('H');
    $condition = '';

    if ($hoursNow >= 19) {
      $condition = 'malam';
    } else if ($hoursNow >= 15) {
      $condition = 'sore';
    } else if ($hoursNow >= 12) {
      $condition = 'siang';
    } else {
      $condition = 'pagi';
    }

    return $condition;
  }
}