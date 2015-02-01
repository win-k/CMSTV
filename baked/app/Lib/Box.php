<?php
class Box
{
  private static $_data = array();

  public static function add($key, $data)
  {
    if (!isset(self::$_data[$key])) self::$_data[$key] = array();

    if (is_string($data)) $data = array($data);
    array_push(self::$_data[$key], $data);
  }

  public static function read($key)
  {
    if (!isset(self::$_data[$key])) return FALSE;

    return self::$_data[$key];
  }

  public static function delete($key, $data)
  {
    if (!isset(self::$_data[$key])) return FALSE;

    foreach (self::$_data[$key] as $k => $v) {
      if ($v == $data) {
        unset(self::$_data[$key][$k]);
        break;
      }
    }

    return TRUE;
  }

}

