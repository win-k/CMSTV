<?php
App::uses('AppShell', 'Console/Command');

class CleanShell extends AppShell
{
  public $uses = array();

  public function getOptionParser()
  {
    $parser = parent::getOptionParser();
    $parser->addOptions(array(
      'build_path' => array(
        'short' => 'b',
        'help' => 'The path to baked_build directory.'
      ),
    ));
    return $parser;
  }

  public function main()
  {
    $this->__prepare();

    $tmpDirPath = rtrim(sys_get_temp_dir(), DS);
    $trashDirPath = $tmpDirPath.DS.uniqid();
    $originalFilesDirPath = WWW_ROOT.'files';

    $this->out(sprintf('Tmp: %s', $tmpDirPath));

    $movedFilesDir = FALSE;
    $copiedFilesDir = FALSE;

    try {
      App::uses('Folder', 'Utility');

      $r = mkdir($trashDirPath);
      if ($r === FALSE) throw new Exception('Failed to make TMP dir. (%s)', $tmpDirPath);


      if (empty($this->params['build_path'])) {
        throw new Exception('Empty build_path option.');
      }

      if (!file_exists($this->params['build_path'])) {
        throw new Exception(sprintf('The build_path path is wrong. (%s)', $this->params['build_path']));
      }

      if (file_exists($originalFilesDirPath)) {
        $r = rename($originalFilesDirPath, $trashDirPath.DS.'files');
        if ($r !== TRUE) throw new Exception(sprintf('Failed to move the files path is wrong. (%s)', $originalFilesDirPath));
        $trashDirPath = TRUE;
      }

      $filesDirPath = $this->params['build_path'].DS.'files';
      if (!file_exists($filesDirPath)) {
        throw new Exception(sprintf('The files path is wrong. (%s)', $filesDirPath));
      }
      $r = copyRecursively($filesDirPath, $originalFilesDirPath);
      if ($r !== TRUE) throw new Exception(sprintf('Failed to copy %s to %s.', $filesDirPath, $originalFilesDirPath));
      $copiedFilesDir = TRUE;


      $myConfPath = ROOT.DS.'my.php';
      $fp = @fopen($myConfPath, 'w');
      if (!$fp) throw new Exception("Failed to open {$myConfPath}");
      if (fwrite($fp, '') === FALSE) throw new Exception("Failed to write to {$myConfPath}");
      $this->out("Clear: {$myConfPath}");


      $tmpDirPath = APP.'tmp';
      $folder = new Folder($tmpDirPath);
      $files = $folder->findRecursive();
      foreach ($files as $file) {
        $r = @unlink($file);
        if ($r === FALSE) throw new Exception("Failed to delete {$file}");
      }
      $this->out("Clear: {$tmpDirPath}");


      $paths = array(
        ROOT.DS.'.git',
        ROOT.DS.'workfiles',
        WWW_ROOT.'files'.DS.'images',
      );
      foreach ($paths as $path) {
        if (!file_exists($path)) continue;
        $folder = new Folder($path);
        $r = $folder->delete();
        if ($r === FALSE) throw new Exception("Failed to delete {$path}");
        $this->out("Clear: {$path}");
      }


      $paths = array(
        ROOT.DS.'.gitignore',
        ROOT.DS.'.project',
      );
      foreach ($paths as $path) {
        if (!file_exists($path)) continue;
        if (!@unlink($path)) throw new Exception("Failed to delete {$path}");
      }


      $files = array('.DS_Store');
      foreach ($files as $file) {
        system(sprintf('find %s -name "%s" -delete', ROOT, $file));
      }


      $pluginPath = APP.'Plugin';
      $folder->path = $pluginPath;
      $excepted = array('ThemeCleanPaperOrange', 'ThemeJanuary', 'ThemeCustom');
      list($dirs, $files) = $folder->read();
      foreach ($dirs as $dir) {
        if (in_array($dir, $excepted)) continue;

        if (preg_match('/^Theme/', $dir)) {
          $path = $pluginPath.DS.$dir;
          $folder->path = $path;
          $r = $folder->delete();
          if ($r === FALSE) throw new Exception("Failed to delete {$path}");
          $this->out("Deleted: {$path}");
        }
      }

    } catch (Exception $e) {
      $this->error($e->getMessage());

      if ($movedFilesDir) {

      }
      if ($copiedFilesDir) {

      }
    }

    $this->out('All done').

    $this->__outputEnd();
  }


}





