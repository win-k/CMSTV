<?php
App::uses('AppController', 'Controller');

class AppAdminController extends AppController
{
  public $uses = array('System', );
  public $helpers = array('Baked');
  protected $title = NULL;

  public function beforeFilter()
  {
    parent::beforeFilter();

    if (empty($_SESSION['Staff'])) $this->redirect('/');
    $this->layout = 'admin';

    $adminInfo = Configure::read("Admin.{$this->plugin}");

    $this->set(array(
      'adminInfo' => $adminInfo,
    ));
  }

  public function beforeRender()
  {
    if (!empty($this->title)) {
      $this->set('title', $this->title);
    }
  }

}
