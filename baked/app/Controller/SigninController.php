<?php
App::uses('AppController', 'Controller');

class SigninController extends AppController
{
  public $uses = array('Staff');
  public $layout = 'system';

  public function beforeFilter()
  {
    parent::beforeFilter();
  }

  public function index()
  {
    if ($this->request->data) {
      $this->tokenFilter();
      try {
        $this->Staff->auth($this->request->data['Staff']);
        $this->Staff->editmode(TRUE);
        $this->redirect('/');
      } catch (Exception $e) {
        Baked::setFlash($e->getMessage(), 'error');
      }
    }

    $this->title = __('サインイン');
  }

  public function editmode($whitch = 1)
  {
    $this->staffFilter();
    $this->Staff->editmode((BOOLEAN)$whitch);

    $f = '/';
    if (!empty($this->request->query['f'])) {
      $f = urldecode($this->request->query['f']);
    }
    $this->redirect($f);
  }

}
