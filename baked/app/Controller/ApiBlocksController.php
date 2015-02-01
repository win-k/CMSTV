<?php
App::uses('AppController', 'Controller');

class ApiBlocksController extends AppController
{
  public $uses = array('Block');
  public $components = array('Api');

  public function beforeFilter()
  {
    parent::beforeFilter();
  }

/**
 * Add the block.
 *
 * @param string $plugin
 * @param int $beforeBlockId
 * @return void
 */
  public function add()
  {
    $this->tokenFilterApi();
    $this->staffFilterApi();

    $r = $this->Block->addByPackage(
      @$this->request->data['page_id'],
      @$this->request->data['package'],
      @$this->request->data['sheet'],
      @$this->request->data['before_block_id'],
      $addedBlockId
    );
    if ($r !== TRUE) $this->Api->ng($r->getMessage());

    $this->Api->ok(array(
      'html' => $this->_htmlBlock($addedBlockId),
    ));
  }


/**
 * Load the block html
 *
 * @return void
 */
  public function html_block()
  {
    $this->tokenFilterApi();
    $this->staffFilterApi();

    $this->Api->ok(array(
      'html' => $this->_htmlBlock($this->request->data['block_id']),
    ));
  }

  public function save_sort()
  {
    $this->tokenFilterApi();
    $this->staffFilterApi();

    foreach ($this->request->data['sorted_ids'] as $sheet => $ids) {
      $sort = 0;
      foreach ($ids as $id) {
        $data = array(
          'id' => $id,
          'sheet' => $sheet,
          'order' => $sort,
        );
        $r = $this->Block->add($data, TRUE);
        $sort++;
      }
    }

    $this->Api->ok();
  }

/**
 * Delete the block.
 *
 * @param int $blockId
 * @return void
 */
  public function delete()
  {
    $this->tokenFilterApi();
    $this->staffFilterApi();

    $r = $this->Block->delete(@$this->request->data['block_id'], TRUE);
    if ($r !== TRUE) $this->Api->ng($r->getMessage());

    $this->Api->ok();
  }

}



