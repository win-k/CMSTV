<?php
App::uses('BlockAppController', 'Controller');

class BlockPhotoGalleryApiController extends BlockAppController
{
  public $uses = array('BlockPhotoGallery.BlockPhotoGallery', 'File');

  public function upload()
  {
    $this->tokenFilterApi();
    $this->staffFilterApi();

    try {
      $this->BlockPhotoGallery->begin();
      $r = $this->File->saveWithFilePost($_FILES['file'], 'image');
      if ($r !== TRUE) throw $r;

      $file = $this->File->find('first', array(
        CONDITIONS => array('File.id' => $this->File->id),
      ));

      $data = $this->BlockPhotoGallery->getData($this->request->data['block_id']);
      if ($data === FALSE) throw new Exception(__('ブロックが見つかりませんでした。'));
      if (!isset($data['photos'])) $data['photos'] = array();
      $photo = array(
        'file_id' => $file['File']['id'],
        'file'    => $file['File'],
        'title'   => NULL,
        'caption' => NULL,
        'alt'     => NULL,
      );
      $data['photos'][$file['File']['id']] = $photo;
      $r = $this->BlockPhotoGallery->updateData($this->request->data['block_id'], $data);
      if ($r !== TRUE) throw $r;
      $this->BlockPhotoGallery->commit();
    } catch (Exception $e) {
      $this->BlockPhotoGallery->rollback();
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

    try {
      $data = $this->BlockPhotoGallery->getData($this->request->data['block_id']);
      if ($data === FALSE) throw new Exception(__('ブロックが見つかりませんでした'));

      $newData = arrayWithKeys($this->request->data, array('slider_theme', 'slider_animation', 'slider_pause_time', 'type'));
      $data = $newData + $data;

      foreach ($data['photos'] as &$photo) {
        $fileId = $photo['file_id'];
        if (!empty($this->request->data['File'][$fileId])) {
          $photo['alt'] = $this->request->data['File'][$fileId]['alt'];
          $photo['title'] = $this->request->data['File'][$fileId]['title'];
        }
      }

      $r = $this->BlockPhotoGallery->updateData($this->request->data['block_id'], $data);
      if ($r !== TRUE) throw $r;
    } catch (Exception $e) {
      $this->Api->ng($e->getMessage());
    }

    $this->Api->ok(array(
      'html' => $this->_htmlBlock($this->request->data['block_id']),
    ));
  }

  public function increase()
  {
    $this->tokenFilterApi();
    $this->staffFilterApi();

    try {
      $data = $this->BlockPhotoGallery->getData($this->request->data['block_id']);
      $data['width'] = (int)$data['width'];
      if ($data['width'] >= 200) throw new Exception(__('これ以上大きくできません。'));
      $data['width'] += 10;

      $r = $this->BlockPhotoGallery->updateData($this->request->data['block_id'], $data);
      if ($r !== TRUE) throw $r;
    } catch (Exception $e) {
      $this->Api->ng($e->getMessage());
    }

    $this->Api->ok(array(
      'html' => $this->_htmlBlock($this->request->data['block_id']),
    ));
  }

  public function decrease()
  {
    $this->tokenFilterApi();
    $this->staffFilterApi();

    try {
      $data = $this->BlockPhotoGallery->getData($this->request->data['block_id']);
      $data['width'] = (int)$data['width'];
      if ($data['width'] <= 50) throw new Exception(__('これ以上小さくできません。'));
      $data['width'] -= 10;

      $r = $this->BlockPhotoGallery->updateData($this->request->data['block_id'], $data);
      if ($r !== TRUE) throw $r;
    } catch (Exception $e) {
      $this->Api->ng($e->getMessage());
    }

    $this->Api->ok(array(
      'html' => $this->_htmlBlock($this->request->data['block_id']),
    ));
  }


  public function save_sort()
  {
    $this->tokenFilterApi();
    $this->staffFilterApi();

    try {
      $r = $this->BlockPhotoGallery->saveSort($this->request->data['block_id'], $this->request->data['file_ids']);
      if ($r !== TRUE) throw $r;
    } catch (Exception $e) {
      $this->Api->ng($e->getMessage());
    }

    $this->Api->ok(array(
      'html' => $this->_htmlBlock($this->request->data['block_id']),
    ));
  }

  public function delete_photo()
  {
    $this->tokenFilterApi();
    $this->staffFilterApi();

    try {
      $r = $this->BlockPhotoGallery->deletePhoto($this->request->data['block_id'], $this->request->data['file_id']);
      if ($r !== TRUE) throw new Exception(__('写真を削除できませんでした。'));
    } catch (Exception $e) {
      $this->Api->ng($e->getMessage());
    }

    $this->Api->ok(array(
      'html' => $this->_htmlBlock($this->request->data['block_id']),
    ));
  }

}

