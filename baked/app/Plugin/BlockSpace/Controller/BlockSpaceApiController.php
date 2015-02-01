<?php
App::uses('BlockAppController', 'Controller');

class BlockSpaceApiController extends BlockAppController
{
  public $uses = array('Block', 'BlockSpace.BlockSpace');

  public function update()
  {
    $this->tokenFilterApi();
    $this->staffFilterApi();

    $data = array(
      'size' => @$this->request->data['size'],
    );
    $r = $this->BlockSpace->updateData(@$this->request->data['block_id'], $data);
    if ($r !== TRUE) $this->Api->ng($r->getMessage());

    $this->Api->ok(array(
      'html' => $this->_htmlBlock($this->request->data['block_id']),
    ));
  }

}

