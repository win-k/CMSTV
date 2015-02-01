<?php
App::uses('AppController', 'Controller');

class BlockAppController extends AppController
{
  public $uses = array('Block');
  public $components = array('Api');

  public function beforeFilter()
  {
    parent::beforeFilter();
  }


}



