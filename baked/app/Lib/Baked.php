<?php
require_once 'Box.php';

class Baked extends Box
{
  public static $_timezone = 'UTC';

/**
 * Check if the plugn is installed.
 *
 * @param string Plugin name
 * @return boolean
 */
  public static function installedPlugin($plugin)
  {
    App::uses('Folder', 'Utility');
    $folder = new Folder(APP.'Plugin');
    list ($plugins) = $folder->read();
    return in_array($plugin, $plugins);
  }

/**
 * Rename the new plug-in directory into Baked plug-ins directory.
 *
 * @param string New plug-in path
 * @param string Plug-in name
 * @return boolean
 */
  public function renamePlugin($pluginPath, $plugin = NULL, &$error)
  {
    $deleted = FALSE;

    $tmpDir = rtrim(sys_get_temp_dir(), DS);
    if (empty($plugin)) $plugin = basename($pluginPath);
    $destPath = APP.'Plugin'.DS.$plugin;
    $deletePath = $tmpDir.DS.uniqid();

    try {
      if (!file_exists($pluginPath)) throw new Exception(__('ディレクトリが見つかりませんでした (%s)', $pluginPath));

      if (!is_writable(APP.'Plugin')) throw new Exception(__('プラグインルートに書き込み権限がありません (%s)', APP.'Plugin'));

      if (file_exists($destPath)) {
        $r = copyRecursively($destPath, $deletePath);
        if (!$r) throw new Exception(__('既存のプラグインをバックアップできませんでした'));

        $r = deleteDir($destPath);
        if (!$r) throw new Exception(__('既存のプラグインをアンインストールできませんでした'));

        $deleted = TRUE;
      }

      $r = rename($pluginPath, $destPath);
      if (!$r) throw new Exception(__('プラグインをインストールできませんでした'));

      return TRUE;
    } catch (Exception $e) {
      if ($deleted) rename($deletePath, $destPath);

      $error = $e->getMessage();

      return FALSE;
    }
  }

/**
 * テーマプラグインの設定ファイルに記述されたリソースファイルを読み込む
 *
 * @return void
 */
  public static function loadThemePluginResources($plugin)
  {
    $resourcesList = Configure::read("Themes.{$plugin}.resources");
    if ($resourcesList) {
      foreach ($resourcesList as $key => $resources) {
        Baked::add($key, $resources);
      }
    }
  }

/**
 * 各種ブロックに必要なリソースを読み込むよう設定
 *
 * @return void
 */
  public static function setupBlocks()
  {
    $searchFilesList = array(
      'CSS' => array(
        '/css/block.css',
      ),
      'CSS_EDITTING' => array(
        '/css/editor.css',
      ),
      'JS' => array(
        '/js/block.js',
      ),
      'JS_EDITTING' => array(
        '/js/editor.js',
      ),
    );

    App::uses('Folder', 'Utility');
    $pluginsRoot = APP.'Plugin';
    $folder = new Folder($pluginsRoot);
    list($plugins, $files) = $folder->read();

    foreach ($plugins as $plugin) {
      if (!preg_match('/^Block/', $plugin)) continue;

      foreach ($searchFilesList as $key => $searchFiles) {
        foreach ($searchFiles as $searchFile) {
          $realpath = $pluginsRoot.'/'.$plugin.'/webroot'.$searchFile;
          if (file_exists($realpath)) {
            $path = '/'.$plugin.$searchFile;
            Baked::add($key, $path);
          }
        }
      }
    }
  }

  public static function setTimezone($timezone)
  {
    self::$_timezone = $timezone;
  }

  public static function dateFormat($utcStr, $format = NULL, $timezone = NULL)
  {
    if (!$format) $format = 'Y-m-d H:i:s';
    if (!$timezone) $timezone = self::$_timezone;

    return CakeTime::format($format, $utcStr, FALSE, $timezone);
  }

  public static function utc($localStr, $timezone = NULL)
  {
    if (!$timezone) $timezone = self::$_timezone;

    $date = new DateTime($localStr, new DateTimeZone($timezone));
    $date->setTimezone(new DateTimeZone('UTC'));
    return $date->format('Y-m-d H:i:s');
  }

  public static function getRequirements()
  {
    require_once APP.'Config/requirements.php';
    return Configure::read('Baked.requirements');
  }

  public static function deleteAllCache()
  {
    App::uses('Folder', 'Utility');
    $folder = new Folder();
    $trees = $folder->tree(APP."tmp/cache", FALSE, 'dir');
    foreach ($trees as $tree) {
      $files = $folder->tree($tree, FALSE, 'file');
      foreach ($files as $file) @unlink($file);
    }
  }

  public static function setFlash($mes, $type)
  {
    $_SESSION['floating_message'] = array(
      'message' => $mes,
      'type'    => $type,
    );
  }

  public static function getFlash()
  {
    $flash = @$_SESSION['floating_message'];
    $_SESSION['floating_message'] = FALSE;
    return $flash;
  }



}





