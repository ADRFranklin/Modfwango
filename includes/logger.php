<?php
  class Logger {
    public static function debug($msg) {
      // Split multi-line messages.
      if (stristr($msg, "\n")) {
        foreach (explode("\n", trim($msg)) as $line) {
          self::displayDebug($line);
        }
        return;
      }
      // If debug mode is on, show debug messages.
      if (__DEBUG__ == true) {
        // Show a message.
        self::displayDebug(trim($msg));
      }
    }

    private static function displayDebug($msg) {
      echo " [ DEBUG ] ".$msg."\n";
    }

    private static function displayInfo($msg) {
      echo "  [ INFO ] ".$msg."\n";
    }

    public static function info($msg) {
      // Split multi-line messages.
      if (stristr($msg, "\n")) {
        foreach (explode("\n", trim($msg)) as $line) {
          self::displayInfo($line);
        }
        return;
      }
      // Show a message.
      self::displayInfo(trim($msg));
    }

    public static function memoryUsage() {
      self::info("Memory Usage:  ".self::prepareNumber(intval(
        memory_get_usage() / 1024 / 1024)). " MB (". self::prepareNumber(intval(
        memory_get_usage() / 1024)). " KB)");
    }

    private static function prepareNumber($num) {
      $num = strval($num);
      if (strlen($num) < 4) {
        return $num;
      }
      $commacount = intval(strlen($num) / 3);
      $number = array();
      $i = 1;
      while ($i <= $commacount) {
        $number[] = substr($num, -($i * 3), 3);
        $i++;
      }

      $remaining = null;
      if (strlen($num) > (count($number) * 3)) {
        $remaining = substr($num, 0, (strlen($num) - (count($number) * 3))).",";
      }
      return $remaining.implode(",", array_reverse($number));
    }
  }
?>
