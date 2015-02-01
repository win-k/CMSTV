<?php
App::uses('BlockAppModel', 'Model');

class BlockLine extends BlockAppModel
{
  public $name = 'BlockLine';
  public $useTable = FALSE;
  public $valid = array(
    'add' => array(
    ),
    'update' => array(
      'id' => 'required | isExist'
    ),
  );
  public $columnLabels = array();

  public function initialData()
  {
    return array();
  }

}



