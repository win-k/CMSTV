<?php
class Reception
{
  private static $_models = array();
  private static $_values = array();

  public static function read($key)
  {
    if (isset(self::$_values[$key])) return self::$_values[$key];

    self::_loadModel('System');

    $systemKey = sprintf('%s', strtoupper($key));
    $value = self::$_models['System']->value($systemKey);

    $value = self::_valueFilter($key, $value);

    return self::$_values[$key] = $value;
  }

  private static function _valueFilter($key, $value)
  {
    if ($key == 'site_caption') {
      if ($value === FALSE) $value = __('サイトの説明を入力');
      return $value;
    }

    if ($key == 'company') {
      if ($value === FALSE) $value = __('会社名を入力');
      return $value;
    }

    if ($key == 'address') {
      if ($value === FALSE) $value = __('住所を入力');
      return $value;
    }

    if ($key == 'tel') {
      if ($value === FALSE) $value = __('電話番号を入力');
      return $value;
    }

    return $value;
  }

  private static function _loadModel($modelName)
  {
    if (isset(self::$_models[$modelName])) return TRUE;
    self::$_models[$modelName] = ClassRegistry::init($modelName);
    return TRUE;
  }

}

