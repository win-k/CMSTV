<?php
/**
 * AutoUpdater
 *
 * @author Masayuki Akiyama
 * @version 0.0.1
 */
class AutoUpdater
{
  public $error = null;
  public $zipUrl = null;
  public $zipBase = 'baked';
  private $_targetDirPath = null;
  private $_progMovedCurrent = FALSE;
  private $_workingPath = null;
  private $_backupPath = null;

  public function setTargetDirPath($path)
  {
    $this->_targetDirPath = $path;

    return TRUE;
  }

  public function update()
  {
    try {
      if (!$this->zipUrl) throw new Exception(__('ZIP URLが不正です'));
      if (!$this->_targetDirPath) throw new Exception(__('インストールパスが不正です'));

      $r = is_writable($this->_targetDirPath);
      if (!$r) throw new Exception(__('インストールパスに書き込み権限がありません (%s)', $this->_targetDirPath));

      $basename = dirname($this->_targetDirPath);
      $r = is_writable($basename);
      if (!$r) throw new Exception(__('インストールパスの親ディレクトリに書き込み権限がありません (%s)', $basename));

      $this->_moveCurrent();
      $this->_extractZip($this->zipUrl, $this->_targetDirPath);
      $this->_copyPeculiarFiles();
      $this->_copyPlugins();

      return TRUE;
    } catch (Exception $e) {
      if ($this->_progMovedCurrent) {
        $this->_rollbackCurrent();
      }
      if ($this->_workingPath) {
        $this->_deleteDir($this->_workingPath);
      }

      $this->error = $e->getMessage();
      return FALSE;
    }
  }

  private function _getTmpPath($path = '')
  {
    $tmpDir = sys_get_temp_dir();
    if (!preg_match('/\\'.DIRECTORY_SEPARATOR.'$/', $tmpDir)) $tmpDir .= DIRECTORY_SEPARATOR;

    return sprintf('%s%s', $tmpDir, $path);
  }

  private function _moveCurrent()
  {
    if (is_null($this->_targetDirPath)) throw new Exception(__('インストールパスが空です'));

    umask(0);

    $this->_workingPath = $this->_getTmpPath(uniqid('bu-'));
    $r = mkdir($this->_workingPath);
    if (!$r) throw new Exception(__('作業ディレクトリを作成できませんでした (%s)', $this->_workingPath));

    $this->_backupPath = $this->_workingPath.DIRECTORY_SEPARATOR.'src';
    $r = mkdir($this->_backupPath);
    if (!$r) throw new Exception(__('バックアップディレクトリを作成できませんでした (%s)', $this->_backupPathb));

    $r = rename($this->_targetDirPath, $this->_backupPath);
    if ($r === FALSE) throw new Exception(__('インストールディレクトリを一時ディレクトリへ移動することができませんでした。%s のパーミッションを確認してください。', $this->_targetDirPath));

    $this->_progMovedCurrent = TRUE;

    return TRUE;
  }

  private function _extractZip($zipUrl, $destination)
  {
    $uniqId = uniqid('auto-update');

    $getTmpZip = $this->_getTmpPath($uniqId.'.zip');
    $r = copy($zipUrl, $getTmpZip);
    if (!$r) throw new Exception(__('zipファイルをダウンロードできませんでした (%s)', $zipUrl));

    $zip = new ZipArchive;
    $r = $zip->open($getTmpZip, ZipArchive::CREATE);
    if ($r !== TRUE) throw new Exception(__('ダウンロードしたzipファイルを開けませんでした。時間をおいてやり直してください (%s)', $zipUrl));

    $extractPath = $this->_getTmpPath($uniqId);
    $zip->extractTo($extractPath);

    $r = rename($extractPath.DIRECTORY_SEPARATOR.$this->zipBase, $destination);
    if (!$r) throw new Exception(__('zipの展開ディレクトリをインストールパスへ移動できませんでした (%s)', $destination));

    unlink($getTmpZip);
    $this->_deleteDir($extractPath);

    return TRUE;
  }

  private function _copyPeculiarFiles()
  {
    $filePrefixes = array(
      '/.htaccess', '/app/.htaccess', '/app/webroot/.htaccess', '/my.php', '/app/webroot/files',
    );

    foreach ($filePrefixes as $filePrefix) {
      $frompath = $this->_backupPath.$filePrefix;
      $destpath = $this->_targetDirPath.$filePrefix;

      if (is_dir($frompath)) {
        if (file_exists($destpath)) {
          $r = $this->_deleteDir($destpath);
          if (!$r) throw new Exception(__('ディレクトリを削除できませんでした (%s)', $destpath));
        }
        $r = $this->_copyRecursively($frompath, $destpath);
        if (!$r) throw new Exception(__('ディレクトリをコピーできませんでした (%s -> %s)', $frompath, $destpath));
      } else {
        $r = copy($frompath, $destpath);
        if (!$r) throw new Exception(__('ファイルをコピーできませんでした (%s -> %s)', $frompath, $destpath));
      }
    }

    return TRUE;
  }

/**
 * 新しいBakedには無くて現行のBakedには存在するPluginディレクトリ以下のディレクトリを全てコピー
 * ただしThemeのプレフィクスを持つディレクトリは新しいBakedに同名のディレクトリがある場合は上書きコピーする
 *
 * @return void
 * @throws Exception
 */
  private function _copyPlugins()
  {
    $fromPluginPath = $this->_backupPath.DIRECTORY_SEPARATOR.'app'.DIRECTORY_SEPARATOR.'Plugin';
    $destPluginPath = $this->_targetDirPath.DIRECTORY_SEPARATOR.'app'.DIRECTORY_SEPARATOR.'Plugin';
    $dir = opendir($fromPluginPath);
    while (FALSE !== ($file = readdir($dir))) {
      if (($file == '.') || ($file == '..')) continue;

      $frompath = $fromPluginPath.DIRECTORY_SEPARATOR.$file;
      $destpath = $destPluginPath.DIRECTORY_SEPARATOR.$file;

      if (!is_dir($frompath)) continue;

      // Theme Plugin
      if (preg_match('/^Theme/', $file)) {
        // Delete the theme plugin if the plugin exists in new Baked plugin directory.
        if (file_exists($destpath)) {
          $r = $this->_deleteDir($destpath);
          if (!$r) throw new Exception(__('ディレクトリを削除できませんでした (%s)', $destpath));
        }
      }
      // Other Plugin
      else {
        // Skip to next if the directory/file exists in the directory of the new Baked.
        if (file_exists($destpath)) continue;
      }

      $r = $this->_copyRecursively($frompath, $destpath);
      if (!$r) throw new Exception(__('プラグインをコピーできませんでした (%s -> %s)', $frompath, $destpath));
    }
    closedir($dir);
  }

  private function _rollbackCurrent()
  {
    $this->_deleteDir($this->_targetDirPath);

    $r = rename($this->_backupPath, $this->_targetDirPath);
    if ($r === FALSE) throw new Exception(__('インストールディレクトリを一時ディレクトリから移動することができませんでした'));

    return TRUE;
  }

  private function _deleteDir($dir)
  {
    if (!is_dir($dir)) {
      return FALSE;
    } else {
      $filelist = scandir($dir);
      foreach ($filelist as $filename) {
        if ($filename == '.' || $filename == '..') continue;
        $path = $dir.DIRECTORY_SEPARATOR.$filename;
        if (is_dir($path)) {
          $this->_deleteDir($path);
        } else {
          unlink($path);
        }
      }
    }
    rmdir($dir);
    return TRUE;
  }

  private function _copyRecursively($src, $dest)
  {
    $src = rtrim($src, DIRECTORY_SEPARATOR);
    $dest = rtrim($dest, DIRECTORY_SEPARATOR);

    $dir = opendir($src);
    mkdir($dest);
    while (FALSE !== ($file = readdir($dir))) {
      if (($file != '.') && ($file != '..')) {
        if (is_dir($src.DIRECTORY_SEPARATOR.$file)) {
          $r = $this->_copyRecursively($src.DIRECTORY_SEPARATOR.$file, $dest.DIRECTORY_SEPARATOR.$file);
          if (!$r) return FALSE;
        } else {
          $r = copy($src.DIRECTORY_SEPARATOR.$file, $dest.DIRECTORY_SEPARATOR.$file);
          if (!$r) return FALSE;
        }
      }
    }
    closedir($dir);

    return TRUE;
  }

}


