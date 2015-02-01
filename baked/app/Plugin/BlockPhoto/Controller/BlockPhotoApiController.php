<?php
App::uses('BlockAppController', 'Controller');

class BlockPhotoApiController extends BlockAppController
{
  public $uses = array('BlockPhoto.BlockPhoto', 'File');

  public function upload()
  {
    $this->tokenFilterApi();
    $this->staffFilterApi();

    try {
      $this->BlockPhoto->begin();

      $r = $this->File->saveWithFilePost($_FILES['file'], 'image');
      if ($r !== TRUE) throw $r;

      $file = $this->File->find('first', array(
        CONDITIONS => array('File.id' => $this->File->id),
      ));

      $data = $this->BlockPhoto->getData($this->request->data['block_id']);
      if (!empty($data['photo'])) {
        $r = $this->File->delete($data['photo']['id']);
        if ($r !== TRUE) throw new Exception(__('古い写真データを削除できませんでした。'));
      }

      if ($data === FALSE) throw new Exception(__('ブロックが見つかりませんでした'));
      $data['photo'] = $file['File'];
      $r = $this->BlockPhoto->updateData($this->request->data['block_id'], $data);
      if ($r !== TRUE) throw $r;
      $this->BlockPhoto->commit();
    } catch (Exception $e) {
      $this->BlockPhoto->rollback();
      $this->Api->ng($e->getMessage());
    }

    $this->Api->ok(array(
      'html' => $this->_htmlBlock($this->request->data['block_id']),
    ));
  }

  public function update()
  {
    $this->tokenFilterApi();
    $this->staffFilterApi();

    $data = arrayWithKeys($this->request->data, array('align', 'size'));
    if (isset($data['size'])) {
      $data['size'] = round($data['size'], -1);
    }
    $r = $this->BlockPhoto->updateData(@$this->request->data['block_id'], $data);
    if ($r !== TRUE) $this->Api->ng($r->getMessage());

    $this->Api->ok(array(
      'html' => $this->_htmlBlock($this->request->data['block_id']),
    ));
  }

}
