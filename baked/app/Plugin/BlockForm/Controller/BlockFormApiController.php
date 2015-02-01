<?php
App::uses('BlockAppController', 'Controller');

class BlockFormApiController extends BlockAppController
{
  public $uses = array('Block', 'BlockForm.BlockForm');

  public function update()
  {
    $this->tokenFilterApi();
    $this->staffFilterApi();

    $data = array(
      'sent_text' => @$this->request->data['Block']['sent_text'],
    );
    $r = $this->BlockForm->updateData(@$this->request->data['Block']['block_id'], $data);
    if ($r !== TRUE) $this->Api->ng($r->getMessage());

    $this->Api->ok(array(
      'html' => $this->_htmlBlock($this->request->data['Block']['block_id']),
    ));
  }

  public function html_add()
  {
    $this->tokenFilterApi();
    $this->staffFilterApi();

    $this->layout = 'ajax';

    if (!empty($this->request->data['BlockForm']['item_id'])) {
      $data = $this->BlockForm->getData(@$this->request->data['BlockForm']['block_id']);
      $item = @$data['items'][$this->request->data['BlockForm']['item_id']];
      if (empty($item)) $this->Api->ng(__('項目が見つかりませんでした'));
      $this->request->data['BlockForm'] += $item;
    }

    $this->Api->ok(array(
      'html' => $this->render()->body(),
    ));
  }

  public function add_item()
  {
    $this->tokenFilterApi();
    $this->staffFilterApi();

    $r = $this->BlockForm->addItem($this->request->data['BlockForm']);
    if ($r !== TRUE) $this->Api->ng($r->getMessage());

    $this->Api->ok(array(
      'html' => $this->_htmlBlock($this->request->data['BlockForm']['block_id']),
      'blockId' => $this->request->data['BlockForm']['block_id'],
    ));
  }

  public function delete_item()
  {
    $this->tokenFilterApi();
    $this->staffFilterApi();

    $r = $this->BlockForm->deleteItem($this->request->data['BlockForm']['block_id'], $this->request->data['BlockForm']['item_id']);

    if ($r !== TRUE) $this->Api->ng($r->getMessage());
    $this->Api->ok(array(
      'html' => $this->_htmlBlock($this->request->data['BlockForm']['block_id']),
    ));
  }

  public function save_sort()
  {
    $this->tokenFilterApi();
    $this->staffFilterApi();

    $r = $this->BlockForm->saveSort($this->request->data['block_id'], $this->request->data['item_ids']);

    if ($r !== TRUE) $this->Api->ng($r->getMessage());
    $this->Api->ok(array(
      'html' => $this->_htmlBlock($this->request->data['block_id']),
    ));
  }

  public function send()
  {
    $this->tokenFilterApi();

    $r = $this->BlockForm->send($this->request->data['block_id'], $this->request->data['items']);
    if ($r !== TRUE) $this->Api->ng(array(
      'errors' => $this->BlockForm->validationErrors,
    ));

    $data = $this->BlockForm->getData($this->request->data['block_id']);
    $this->Api->ok(array(
      'data' => $data,
    ));
  }

}













