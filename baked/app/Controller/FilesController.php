<?php
App::uses('AppController', 'Controller');

class FilesController extends AppController
{
  public $uses = array('File');
  public static $MIN_IMAGE_SIZE = 20;
  public static $MAX_IMAGE_SIZE = 1000;
  public static $STEP_IMAGE_SIZE = 10;
  private $_overwrite_dir = NULL;

  public function images($type, $size, $name)
  {
    $this->__save_image($type, $size, $name);
    exit;
  }

  public function block_images()
  {
    $args = func_get_args();
    $package = array_shift($args);
    if (empty($package)) $this->__show404();

    $package = Inflector::camelize($package);
    $this->uses[] = sprintf('%s.%s', $package, $package);
    $this->{$package}->create();
    $r = $this->{$package}->getFileInfo($args);
    if ($r === FALSE) $this->__show404();

    if (!empty($r['overwrite_dir'])) $this->_overwrite_dir = $r['overwrite_dir'];
    $this->__save_image($r['type'], $r['size'], $r['name']);
    exit;
  }

  private function __save_image($type, $size, $name)
  {
    if ($size < self::$MIN_IMAGE_SIZE
      || $size > self::$MAX_IMAGE_SIZE
      || $size % self::$STEP_IMAGE_SIZE != 0
    ) $this->__show404();

    list($code, $ext) = explode('.', $name);

    $file = $this->File->find('first', array(
      CONDITIONS => array(
        'File.code' => $code,
        'File.ext'  => $ext,
      ),
      FIELDS => array('File.path', 'File.mime', 'File.code', 'File.ext'),
    ));
    if (empty($file)) $this->__show404();

    if ($type == 'width') {
      $this->__images_width($size, $file);
    } else if ($type == 'height') {
      $this->__images_height($size, $file);
    } else if ($type == 'square') {
      $this->__images_square($size, $file);
    } else {
      $this->__show404();
    }
  }

  private function __images_width($size, $file)
  {
    $dir = WWW_ROOT."files/images/width/{$size}";
    if ($this->_overwrite_dir) $dir = $this->_overwrite_dir;
    $this->__create_dir_if_needed($dir);
    $newPath = sprintf('%s/%s.%s', $dir, $file['File']['code'], $file['File']['ext']);

    $image = $this->__instance_zebra_image();
    $image->source_path = $file['File']['absolute_path'];
    $image->target_path = $newPath;
    $image->resize($size, 0, ZEBRA_IMAGE_CROP_CENTER);

    header('Content-Type: '.$file['File']['mime']);
    readfile($newPath);
  }

  private function __images_height($size, $file)
  {
    $dir = WWW_ROOT."files/images/height/{$size}";
    if ($this->_overwrite_dir) $dir = $this->_overwrite_dir;
    $this->__create_dir_if_needed($dir);
    $newPath = sprintf('%s/%s.%s', $dir, $file['File']['code'], $file['File']['ext']);

    $image = $this->__instance_zebra_image();
    $image->source_path = $file['File']['absolute_path'];
    $image->target_path = $newPath;
    $image->resize(0, $size, ZEBRA_IMAGE_CROP_CENTER);

    header('Content-Type: '.$file['File']['mime']);
    readfile($newPath);
  }

  private function __images_square($size, $file)
  {
    $dir = WWW_ROOT."files/images/square/{$size}";
    if ($this->_overwrite_dir) $dir = $this->_overwrite_dir;
    $this->__create_dir_if_needed($dir);
    $newPath = sprintf('%s/%s.%s', $dir, $file['File']['code'], $file['File']['ext']);

    $image = $this->__instance_zebra_image();
    $image->source_path = $file['File']['absolute_path'];
    $image->target_path = $newPath;
    $image->resize($size, $size, ZEBRA_IMAGE_CROP_CENTER);

    header('Content-Type: '.$file['File']['mime']);
    readfile($newPath);
  }

  private function __instance_zebra_image()
  {
    require_once APP.'Lib/Zebra_Image.php';
    $image = new Zebra_Image();
    $image->jpeg_quality = 100;
    $image->preserve_aspect_ratio = TRUE;
    $image->enlarge_smaller_images = TRUE;
    $image->preserve_time = TRUE;
    return $image;
  }

  private function __create_dir_if_needed($dir)
  {
    if (!file_exists($dir)) {
      App::uses('Folder', 'Utility');
      $folder = new Folder();
      if (!$folder->create($dir, 0707)) throw new Exception(__('フォルダの作成に失敗しました。'));
    }
  }

  private function __show404()
  {
    header('HTTP/1.1 404 Not Found');
    exit;
  }

}



































