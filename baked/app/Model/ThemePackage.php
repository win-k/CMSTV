<?php
App::uses('AppModel', 'Model');

class ThemePackage extends AppModel
{
  public $name = 'ThemePackage';
  public $useTable = FALSE;

  public function extractZip($zippath, $plugin, &$pluginPath)
  {
    $zipOpened = FALSE;

    try {
      $tmpDir = rtrim(sys_get_temp_dir(), DS);
      $uniqId = uniqid('baked-theme-');

      $parsed = parse_url($zippath);
      if (!empty($parsed['scheme']) && in_array($parsed['scheme'], array('http', 'https', 'ftp', 'ftps'))) {
        $newZippath = $tmpDir.DS.$uniqId.'.zip';
        $r = @copy($zippath, $newZippath);
        if ($r === FALSE) throw new Exception(__('ZIPファイルをダウンロードできませんでした'));
        $zippath = $newZippath;
      }

      $zip = new ZipArchive;
      $r = $zip->open($zippath);
      if ($r !== TRUE) throw new Exception(__('ZIPファイルを開けませんでした (%s)', $zippath));
      $zipOpened = TRUE;

      $extractPath = $tmpDir.DS.$uniqId;
      $zip->extractTo($extractPath);
      $zip->close();
      $zipOpened = FALSE;

      $pluginPath = $extractPath.DS.$plugin;
      if (!file_exists($pluginPath)) throw new Exception(__('解凍したテーマディレクトリの中に %s プラグインが見つかりませんでした', $plugin));

      return TRUE;
    } catch (Exception $e) {
      if ($zipOpened) $zip->close();

      return $e;
    }
  }

  public function installed()
  {
    $themePackages = Configure::read('Themes');
    return $themePackages;
  }

/**
 * ファイルパスに書き込み
 *
 * @param string $path
 * @param string $text
 * @return mixed true on success. Exception on failed.
 */
  public function write($path, $text)
  {
    try {
      $fp = @fopen($path, 'r+');
      if (!$fp) throw new Exception(__('ファイルを開けませんでした (%s)', $path));

      $r = fwrite($fp, $text);
      if (!$r) throw new Exception(__('書き込みに失敗しました (%s)', $path));
      return TRUE;
    } catch (Exception $e) {
      return $e;
    }
  }

  public function setUsed($package, $type)
  {
    try {
      $this->begin();

      $themePackage = Configure::read("Themes.{$package}");
      if (empty($themePackage)) throw new Exception(__('テーマが見つかりませんでした'));

      if (!in_array($type, array('pc', 'mobile'))) throw new Exception(__('テーマタイプが不正です'));
      if (!$themePackage['support'][$type]) throw new Exception(__('このテーマは選択したタイプに対応していません (type:%s)', $type));

      $this->loadModel('System');

      if ($type == 'pc') {
        $key = System::KEY_USE_THEME;
      } else {
        $key = System::KEY_USE_THEME_MOBILE;
      }
      $this->System->saveValue($key, $package);

      $this->commit();
      return TRUE;
    } catch (Exception $e) {
      $this->rollback();
      return $e;
    }
  }

  public function remove($package)
  {
    try {
      $this->begin();

      $themePackage = Configure::read("Themes.{$package}");
      if (empty($themePackage)) throw new Exception(__('テーマが見つかりませんでした'));

      $this->loadModel('System');
      $useTheme = $this->System->value(System::KEY_USE_THEME);
      $useThemeMobile = $this->System->value(System::KEY_USE_THEME_MOBILE);

      if (in_array($package, array($useTheme, $useThemeMobile))) {
        throw new Exception(__('使用中のテーマは削除できません'));
      }

      $this->loadModel('Plugin');
      $r = $this->Plugin->remove($package);
      if ($r !== TRUE) throw new Exception(__('プラグインの削除に失敗しました'));

      Baked::deleteAllCache();

      $this->commit();
      return TRUE;
    } catch (Exception $e) {
      $this->rollback();
      return $e;
    }
  }

}
