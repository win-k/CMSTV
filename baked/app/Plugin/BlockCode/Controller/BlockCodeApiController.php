<?php
App::uses('BlockAppController', 'Controller');

class BlockCodeApiController extends BlockAppController
{
  public $uses = array('Block', 'BlockCode.BlockCode');

  public function update()
  {
    $this->tokenFilterApi();
    $this->staffFilterApi();

    $data = array(
      'code' => @$this->request->data['Block']['code'],
    );
    $r = $this->BlockCode->updateData(@$this->request->data['block_id'], $data);
    if ($r !== TRUE) $this->Api->ng($r->getMessage());

    $this->Api->ok(array(
      'html' => $this->_htmlBlock($this->request->data['block_id']),
    ));
  }

}

