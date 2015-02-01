<?php
App::uses('BlockAppModel', 'Model');

class BlockPhoto extends BlockAppModel
{
  public $name = 'BlockPhoto';
  public $useTable = FALSE;
  public $valid = array(
    'add' => array(
      'align'   => 'notEmpty | inClassArrayKeys[ALIGN]',
      'size'    => 'notEmpty | int',
    ),
    'update' => array(
      'id' => 'required | isExist'
    ),
  );
  public $columnLabels = array();
  public static $ALIGN = array(1 => 'left', 2 => 'center', 3 => 'right');

  public function initialData()
  {
    return array(
      'align' => 2,
      'size'  => 300,
      'photo' => array(),
    );
  }

  public function willDelete($blockId)
  {
    try {
      $data = $this->getData($blockId);
      if (empty($data)) throw new Exception(__('ブロックが見つかりませんでした。'));

      if (!empty($data['photo'])) {
        $this->loadModel('File');
        $r = $this->File->delete($data['photo']['id']);
        if ($r !== TRUE) throw new Exception(__('写真を削除できませんでした。'));
      }

      return TRUE;
    } catch (Exception $e) {
      return FALSE;
    }
  }



}



