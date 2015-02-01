<?php
App::uses('AppController', 'Controller');

class ApiCommentsController extends AppController
{
  public $uses = array('Comment', 'Entry');
  public $components = array('Api');

  public function beforeFilter()
  {
    parent::beforeFilter();
  }

/**
 * コメント投稿画面
 *
 * @return void
 */
  public function html_editor()
  {
    $this->tokenFilter();
    $this->layout = 'ajax';

    $options = $this->Entry->getOptions(array(Entry::OPTION_BIND_PAGE), array(
      CONDITIONS => array(
        'Entry.id' => @$this->request->data['entry_id'],
      ),
      FIELDS => array(
        'Entry.id', 'Entry.title',
        'Page.package', 'Page.data',
      ),
    ));
    $entry = $this->Entry->find('first', $options);
    if (empty($entry)) die(__('エントリが見つかりませんでした'));
    if ($entry['Page']['data']['can_comment'] == 0) die(__('このエントリはコメントを受け付けていません'));

    $this->set(array(
      'entry' => $entry,
    ));
  }

  public function send()
  {
    $this->tokenFilterApi();
    $this->layout = 'ajax';

    $r = $this->Comment->submit(@$this->request->data, $page);
    if ($r !== TRUE) $this->Api->ng($r->getMessage());

    $this->set(array(
      'page' => $page,
    ));

    $this->Api->ok(array(
      'html' => $this->render()->body(),
    ));
  }
}


