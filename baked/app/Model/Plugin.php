<?php
App::uses('AppModel', 'Model');

class Plugin extends AppModel
{
  public $name = 'Plugin';
  public $useTable = FALSE;

  public function remove($plugin)
  {
    App::uses('Folder', 'Utility');
    $folder = new Folder();
    $r = $folder->delete(APP."Plugin/{$plugin}");


    return $r;
  }

}
