<?php
App::uses('AppModel', 'Model');

class BlockAppModel extends AppModel
{
  public $name = 'BlockAppModel';
  public $useTable = FALSE;

  public function valid($data)
  {
    return $this->add($data, NULL, NULL, self::VALIDATION_MODE_ONLY);
  }

  public function convert($block)
  {
    return $block;
  }

  public function getFileInfo($args)
  {
    return FALSE;
  }

  public function updateData($id, $data)
  {
    try {
      $this->begin();

      $r = $this->valid($data);
      if ($r !== TRUE) throw $r;

      $this->loadModel('Block');
      $r = $this->Block->updateData($id, $data);
      if ($r !== TRUE) throw $r;

      $this->commit();
      return TRUE;
    } catch (Exception $e) {
      $this->rollback();
      return $e;
    }
  }

  public function getData($id)
  {
    $this->loadModel('Block');
    $block = $this->Block->find('first', array(
      CONDITIONS => array('Block.id' => $id),
      FIELDS => array('Block.data'),
    ));
    if (empty($block)) return FALSE;

    return $block['Block']['data'];
  }

/**
 * Return initiali data
 *
 * @return mixed array on success. true to ignore. false to occur error.
 */
  public function initialData()
  {
    return TRUE;
  }

/**
 * Callback before delete.
 *
 * @param int $blockId
 * @return boolean
 */
  public function willDelete($blockId)
  {
    return TRUE;
  }

}




















