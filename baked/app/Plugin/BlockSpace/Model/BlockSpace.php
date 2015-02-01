<?php
App::uses('BlockAppModel', 'Model');

class BlockSpace extends BlockAppModel
{
  public $name = 'BlockSpace';
  public $useTable = FALSE;
  public $valid = array(
    'add' => array(
      'size'    => 'notEmpty | int',
    ),
    'update' => array(
      'id' => 'required | isExist'
    ),
  );
  public $columnLabels = array();

  public function initialData()
  {
    return array(
      'size' => 20,
    );
  }

}



