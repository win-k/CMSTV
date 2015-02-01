<?php
App::uses('AppPage', 'Lib/PagePattern');

class PageBlog extends  AppPage
{
  public $view = 'blog';

  public function convert()
  {
    if (!empty($this->controller->request->query['e'])) {
      $this->__setEntry();
    } elseif (@$this->controller->request->query['mode'] == 'preview') {
      $this->__setPreview();
    } else {
      $this->__setList();
    }
  }

  private function __setList()
  {
    $options = $this->controller->Entry->getOptions(array(Entry::OPTION_BIND_PAGE), array(
      CONDITIONS => array(
        'Entry.page_id' => $this->page['Page']['id'],
        'Entry.published <=' => date('Y-m-d H:i:s'),
      ),
      ORDER => array('Entry.published' => 'desc'),
      FIELDS => array(
        'Entry.id', 'Entry.title', 'Entry.body1', 'Entry.body2', 'Entry.published', 'Entry.approved_comments_count',
        'Page.path',
      ),
      'paramType' => 'querystring',
      'limit' => $this->page['Page']['data']['entries_per_page'],
    ));
    $this->controller->paginate = $options;
    $entries = $this->controller->paginate('Entry');

    $this->controller->set(array(
      'entries' => $entries,
    ));
  }

  private function __setEntry()
  {
    $options = $this->controller->Entry->getOptions(array(Entry::OPTION_BIND_PAGE), array(
      CONDITIONS => array(
        'Entry.id' => $this->controller->request->query['e'],
        'Entry.published <=' => date('Y-m-d H:i:s'),
      ),
      FIELDS => array(
        'Entry.id', 'Entry.title', 'Entry.body1', 'Entry.body2', 'Entry.published', 'Entry.created', 'Entry.approved_comments_count',
        'Page.path',
      ),
    ));
    $entry = $this->controller->Entry->find('first', $options);
    if (empty($entry)) {
      $this->view = '404';
      return FALSE;
    }

    $options = $this->controller->Comment->getOptions(array(), array(
      CONDITIONS => array(
        'Comment.entry_id' => $this->controller->request->query['e'],
        'Comment.approved' => 1,
      ),
      ORDER => array('Comment.created' => 'asc'),
      FIELDS => array(
        'Comment.id', 'Comment.name', 'Comment.body', 'Comment.created',
      ),
    ));
    $comments = $this->controller->Comment->find('all', $options);

    $this->view = 'entry';

    $this->controller->set(array(
      'entry' => $entry,
      'comments' => $comments,
    ));
  }

  private function __setPreview()
  {
    $this->controller->staffFilter();

    $entry = array('Entry' => $_SESSION['preview_entry']) + $this->page;
    $entry['Entry']['id'] = 0;
    $entry['Entry']['published'] = date('Y-m-d H:i:s');
    $entry['Entry']['path'] = $this->page['Page']['path'];
    $entry['Entry']['approved_comments_count'] = 0;

    $this->view = 'entry';

    $this->controller->set(array(
      'entry' => $entry,
      'comments' => array(),
    ));
  }

}



