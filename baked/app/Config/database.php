<?php
class DATABASE_CONFIG
{
  public $default = array(
    'datasource' => 'Database/Mysql',
    'persistent' => FALSE,
  );

  public function __construct()
  {
    if (defined('MY_DB_HOST')) {
      $this->default = array(
        'datasource' => 'Database/Mysql',
        'persistent' => FALSE,
        'host' => MY_DB_HOST,
        'login' => MY_DB_USER,
        'password' => MY_DB_PASSWORD,
        'database' => MY_DB_NAME,
        'prefix' => MY_DB_PREFIX,
        'encoding' => MY_DB_ENCODING,
      );
    }
  }
}

