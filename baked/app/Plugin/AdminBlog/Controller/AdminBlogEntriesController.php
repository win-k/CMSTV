<?php
App::uses('AppAdminBlogController', 'AdminBlog.Controller');

class AdminBlogEntriesController extends AppAdminBlogController
{
  public $uses = array('Entry', 'Page');

  public function beforeFilter()
  {
    parent::beforeFilter();

    Baked::add('ADMIN_CSS', array());
    Baked::add('ADMIN_JS', array('/AdminBlog/js/interface.js'));
  }

  public function listing($pageId)
  {
    if (!empty($this->request->data['Entry']['mode']) && !empty($this->request->data['Entry']['id'])) {
      $this->tokenFilter();
      switch ($this->request->data['Entry']['mode']) {
        case 'delete': $this->__delete(); break;
      }
    }

    $options = $this->Page->getOptions(array(), array(
      CONDITIONS => array(
        'Page.id' => $pageId,
      ),
      FIELDS => array('Page.id', 'Page.title', 'Page.name', 'Page.path'),
    ));
    $page = $this->Page->find('first', $options);
    if (empty($page)) {
      $this->redirect('/admin/blog/blogs/listing');
    }

    $this->title = __('「%s」のエントリ一覧', $page['Page']['title']);

    $this->paginate = $this->Entry->getOptions(array(Entry::OPTION_BIND_STAFF_NO_RESET), array(
      CONDITIONS => array(
        'Entry.page_id' => $pageId,
      ),
      FIELDS => array(
        'Entry.id', 'Entry.page_id', 'Entry.title', 'Entry.published', 'Entry.comments_count', 'Entry.unapproved_comments_count',
        'Staff.id', 'Staff.name',
      ),
      ORDER => array('Entry.published' => 'desc'),
      'limit' => 20,
      'paramType' => 'querystring',
    ));
    $entries = $this->paginate('Entry');

    $this->set(array(
      'page' => $page,
      'entries' => $entries,
    ));
  }

  public function add($entryId = NULL)
  {
    $this->title = __('エントリを書く');

    if ($entryId) {
      $entry = $this->Entry->find('first', array(
        CONDITIONS => array(
          'Entry.id' => $entryId,
        ),
        FIELDS => array(
          'Entry.id', 'Entry.page_id', 'Entry.title', 'Entry.body1', 'Entry.body2', 'Entry.created', 'Entry.published', 'Entry.modified',
        ),
      ));
      if (empty($entry)) $this->redirect('/admin/blog/entries/listing');
    }

    $blogs = $this->Page->find('all', array(
      CONDITIONS => array(
        'Page.package' => 'PageBlog',
      ),
      FIELDS => array(
        'Page.id', 'Page.title', 'Page.name', 'Page.path', 'Page.data',
      ),
    ));

    if ($this->request->data) {
      $this->tokenFilter();
      $data = arrayWithKeys($this->request->data['Entry'], array(
        'id', 'page_id', 'title', 'body1', 'body2', 'published',
      ));
      if (empty($data['id'])) $data['staff_id'] = $_SESSION['Staff']['id'];
      if (!empty($data['published'])) $data['published'] = Baked::utc($data['published']);
      $r = $this->Entry->add($data);
      if ($r === TRUE) {
        Baked::setFlash(__('記事を保存しました'), 'success');
        $this->redirect("/admin/blog/entries/add/{$this->Entry->id}");
      } else {
        Baked::setFlash(__('入力内容に不備があります'), 'error');
      }
    } else if (!empty($entry)) {
      $this->request->data = $entry;
    } else if ($this->request->query) {
      $this->request->data['Entry'] = $this->request->query;
    }

    if (empty($this->request->data['Entry']['published']))
      $this->request->data['Entry']['published'] = date('Y-m-d H:i');

    $this->set(array(
      'blogs' => $blogs,
    ));
  }

  private function __delete()
  {
    $count = 0;

    foreach (@$this->request->data['Entry']['id'] as $entryId) {
      $r = $this->Entry->delete($entryId);
      if ($r === TRUE) $count++;
    }

    Baked::setFlash(__('%s件のエントリを削除しました', $count), 'success');
  }

}









