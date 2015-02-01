<?php
App::uses('AppModel', 'Model');

class File extends AppModel
{
  public $valid = array(
    'add' => array(
      'mime'  => 'required',
      'ext'   => 'required',
      'size'  => 'required | int',
      'code'  => 'required | isUnique | equalLen[16]',
      'path'  => 'required',
    ),
    'update' => array(
      'id'    => 'required | isExist',
    ),
    'image' => array(
      'type'        => 'valid_image',
      'ext'         => 'required',
    ),
  );
  public $columnLabels = TRUE;
  static public $widthList = array(
    '160', '320', '480', '640'
  );

  public function loadValidate()
  {
    parent::loadValidate();

    if (!empty($this->validate['type']['valid_image']))
      $this->validate['type']['valid_image']['message'] = '画像ファイルを選択してください';
  }

  public function afterFind($results, $primary = FALSE)
  {
    foreach ($results as &$result) {
      $data;
      if (isset($result[$this->name])) $data = &$result[$this->name];
      else $data = &$result;

      if (!empty($data['path'])) {
        $data['absolute_path'] = sprintf('%s%s/%s', WWW_ROOT, 'files', $data['path']);
      }
    }

    return $results;
  }

/**
 * ファイルからレコードを作成
 *
 * @param string $path ファイルパス
 * @param string $mimeType マイムタイプ
 * @param string $useValid バリデーションを実行する場合は使用するルールを指定。
 * @return mixed true on success. Exception on failure.
 */
  public function addFile($path, $mimeType, $useValid = NULL)
  {
    try {
      $this->begin();

      if (!file_exists($path)) throw new Exception(__('ファイルが見つかりませんでした。'));

      $code = $this->generateUniqueCode(16);
      $ext = extWithMime($mimeType);

      $dir = sprintf('original/%s/%s/', date('Y'), date('m'));
      $absDir = sprintf('%sfiles/%s', WWW_ROOT, $dir);
      if (!file_exists($absDir)) {
        App::uses('Folder', 'Utility');
        $folder = new Folder();
        if (!$folder->create($absDir, 0707)) throw new Exception(__('フォルダの作成に失敗しました。'));
      }

      $dbPath = sprintf('%s%s.%s', $dir, $code, $ext);

      $data = array(
        'path'    => $dbPath,
        'ext'     => $ext,
        'size'    => filesize($path),
        'mime'    => $mimeType,
        'code'    => $code,
      );

      $r = $this->add($data, FALSE, $useValid);
      if ($r !== TRUE) throw $r;

      $absPath = sprintf('%s%s.%s', $absDir, $code, $ext);
      if (!move_uploaded_file($path, $absPath)) throw new Exception(__('ファイルの移動に失敗しました。'));

      $this->commit();
      return TRUE;
    } catch (Exception $e) {
      #echo $e->getMessage()."\n";
      $this->rollback();
      return $e;
    }
  }

/**
 * $_FILE形式の配列からファイルを保存
 *
 * @param string $file array(name,type,tmp_name,errpr,size)
 * @param string $useValid バリデーションを実行する場合は使用するルールを指定。falseの場合はバリデーションなし。
 * @return mixed Same as File::addFile
 */
  public function saveWithFilePost($file, $useValid = FALSE)
  {
    return $this->addFile($file['tmp_name'], $file['type'], $useValid);
  }

  public function delete($id = null, $cascade = true)
  {
    try {
      $this->begin();

      $file = $this->find('first', array(
        CONDITIONS => array('File.id' => $id),
        FIELDS => array('File.path'),
      ));
      if (empty($file)) throw new Exception(__('Fileレコードが見つかりませんでした。'));

      if (file_exists($file['File']['absolute_path'])) {
        $r = @unlink($file['File']['absolute_path']);
        if ($r !== TRUE) throw new Exception(__('ファイルソースを削除できませんでした。'));
      }

      $r = parent::delete($id, $cascade);
      if ($r !== TRUE) throw new Exception(__('Fileレコードを削除できませんでした。'));

      $this->commit();
      return TRUE;
    } catch (Exception $e) {
      $this->rollback();
      return FALSE;
    }
  }

/**
 * バリデーションルール
 * 画像ファイルかどうか
 */
  public function valid_image(&$model, $data)
  {
    $imageTypes = array(
      'image/jpeg', 'image/jpg', 'image/gif', 'image/png',
    );

    return in_array($this->data[$this->name]['type'], $imageTypes);
  }


}












