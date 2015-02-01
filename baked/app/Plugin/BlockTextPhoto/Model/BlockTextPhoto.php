<?php
App::uses('BlockAppModel', 'Model');

class BlockTextPhoto extends BlockAppModel
{
  public $name = 'BlockTextPhoto';
  public $useTable = FALSE;
  public $valid = array(
    'add' => array(
      #'text'    => '',
      'align'   => 'notEmpty | inClassArrayKeys[ALIGN]',
      'size'    => 'notEmpty | int',
    ),
    'update' => array(
      'id' => 'required | isExist'
    ),
  );
  public $columnLabels = array();
  public static $ALIGN = array(1 => 'left', 2 => 'right');

  public function initialData()
  {
    return array(
      'text' => __('テキストを入力してください。'),
      'align' => 2,
      'size'  => 200,
      'photo' => NULL,
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
        if ($r !== TRUE) throw new Exception('Failed to delete photo.');
      }

      return TRUE;
    } catch (Exception $e) {
      return FALSE;
    }
  }



}



