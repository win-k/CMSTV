<?php
App::uses('AppController', 'Controller');

class ApiSystemController extends AppController
{
  public $uses = array('System', 'Staff', 'Page', );
  public $components = array('Api');

  public function beforeFilter()
  {
    parent::beforeFilter();
  }

  public function save_session()
  {
    $this->tokenFilterApi();
    $_SESSION[$this->request->data['name']] = $this->request->data['data'];
    $this->Api->ok();
  }

/**
 * ページ情報を取得
 */
  public function page_info()
  {
    $this->tokenFilterApi();
    $this->staffFilterApi();

    $page = $this->Page->find('first', array(
      CONDITIONS => array(
        'Page.id' => @$this->request->data['page_id'],
      ),
    ));
    if (empty($page)) $this->Api->ng(__('ページが見つかりませんでした'));

    $this->Api->ok(array(
      'page' => $page,
    ));
  }

  public function sign_in()
  {
    $this->tokenFilterApi();

    try {
      $this->Staff->auth($this->request->data['Staff']);
    } catch (Exception $e) {
      $this->Api->ng($e->getMessage());
    }

    $this->Api->ok();
  }

  public function sign_out()
  {
    $this->tokenFilterApi();
    $this->staffFilterApi();

    try {
      $this->Staff->signOut();
    } catch (Exception $e) {
      $this->Api->ng($e->getMessage());
    }

    $this->Api->ok();
  }

  public function go_editmode()
  {
    $this->tokenFilterApi();

    if (empty($_SESSION['Staff'])) $this->Api->ng(__('サインインしてください。'));

    $this->Staff->editmode(TRUE);
    $this->Api->ok();
  }

  public function cancel_editmode()
  {
    $this->tokenFilterApi();
    $this->staffFilterApi();

    $this->Staff->editmode(FALSE);
    $this->Api->ok();
  }

  public function signed_in()
  {
    $result = array();

    if (!empty($_SESSION['Staff'])) {
      $result['signed'] = TRUE;
    } else {
      $result['signed'] = FALSE;
    }
    $result['editmode'] = (@$_SESSION['Staff']['Editmode'] === TRUE);

    $this->Api->ok($result);
  }

  public function html_signin()
  {
    $this->layout = 'ajax';
  }

}

