<?php
App::uses('AppController', 'Controller');

class ApiPagesController extends AppController
{
  public $uses = array('Page');
  public $components = array('Api');

  public function beforeFilter()
  {
    parent::beforeFilter();
  }

/**
 * Load the pages manager html
 *
 * @return void
 */
  public function html_manager()
  {
    $this->tokenFilterApi();
    $this->staffFilterApi();

    $pages = $this->Page->find('all', array(
      ORDER => array(
        'Page.order' => 'asc',
      ),
    ));

    $this->set(array(
      'pages' => $pages,
    ));

    $this->layout = 'ajax';
    $this->Api->ok(array(
      'html' => $this->render()->body(),
    ));
  }

  public function insert()
  {
    $this->tokenFilterApi();
    $this->staffFilterApi();

    $r = $this->Page->insertPage(NULL, NULL, @$this->request->data['package'], @$this->request->data['before_page_id']);
    if ($r !== TRUE) $this->Api->ng($r->getMessage());
    $this->Api->ok();
  }

  public function delete()
  {
    $this->tokenFilterApi();
    $this->staffFilterApi();

    $r = $this->Page->delete($this->request->data['page_id']);
    if ($r !== TRUE) $this->Api->ng($r->getMessage());
    $this->Api->ok();
  }

  public function update_all()
  {
    $this->tokenFilterApi();
    $this->staffFilterApi();

    usort($this->request->data['Page'], function($a, $b) {
      return $a['order'] > $b['order'];
    });
    $r = $this->Page->update($this->request->data['Page']);

    if ($r !== TRUE) $this->Api->ng(array(
      'message'=>$r->getMessage(),
      'before'=>$this->request->data['Page'],
    ));

    $this->Api->ok();
  }

}
