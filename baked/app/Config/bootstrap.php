<?php
CakePlugin::loadAll(array(
  array('bootstrap' => TRUE),
));

Configure::write('Config.unavailable', array(
  'system', 'plugin', 'admin', 'files',
));

Cache::config('default', array('engine' => 'File'));

Configure::write('Dispatcher.filters', array(
  'AssetDispatcher',
  'CacheDispatcher'
));

App::uses('CakeLog', 'Log');
CakeLog::config('debug', array(
  'engine' => 'FileLog',
  'types' => array('notice', 'info', 'debug'),
  'file' => 'debug',
));
CakeLog::config('error', array(
  'engine' => 'FileLog',
  'types' => array('warning', 'error', 'critical', 'alert', 'emergency'),
  'file' => 'error',
));

App::uses('CakeTime', 'Utility');
