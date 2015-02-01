<?php
App::uses('AppModel', 'Model');

class BlockPackage extends AppModel
{
  public $name = 'BlockPackage';
  public $useTable = FALSE;

  public function installed()
  {
    $blockPackages = Configure::read('Blocks');
    return $blockPackages;
  }

}
