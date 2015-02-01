<?php
App::uses('AppAdminBlogController', 'AdminBlog.Controller');

class AdminBlogCommentsController extends AppAdminBlogController
{
  public $uses = array('Page', 'Comment');

  public function listing()
  {
    $this->title = __('コメント一覧');

    if (!empty($this->request->data['Comment']['mode']) && !empty($this->request->data['Comment']['id'])) {
      $this->tokenFilter();
      switch ($this->request->data['Comment']['mode']) {
        case 'approve': $this->__approve(); break;
        case 'unapprove': $this->__unapprove(); break;
        case 'delete': $this->__delete(); break;
      }
    }

    $options = array(
      CONDITIONS => array(),
      FIELDS => array(
        'Comment.id', 'Comment.name', 'Comment.body', 'Comment.entry_id', 'Comment.page_path', 'Comment.ip', 'Comment.host', 'Comment.approved', 'Comment.created',
        'Entry.title',
      ),
      'limit' => 20,
      'paramType' => 'querystring',
    );

    if (!empty($this->request->query['body'])) {
      $options[CONDITIONS] += $this->Comment->generateSearchConditions($this->request->query['body'], array('body'));
    }

    if (!empty($this->request->query['page_id'])) {
      $options[CONDITIONS] += array(
        'Entry.page_id' => $this->request->query['page_id'],
      );
    }

    if (!empty($this->request->query['entry_id'])) {
      $options[CONDITIONS] += array(
        'Comment.entry_id' => $this->request->query['entry_id'],
      );
    }

    if (!empty($this->request->query['noapproved'])) {
      $options[CONDITIONS] += array(
        'Comment.approved' => FALSE,
      );
    }

    if ($this->request->query) $this->request->data['Comment'] = $this->request->query;

    $this->paginate = $this->Comment->getOptions(array(Comment::OPTION_BIND_ENTRY_NO_RESET), $options);
    $comments = $this->paginate('Comment');

    $pageIds = $this->Page->find('list', array(
      CONDITIONS => array(
        'Page.package' => 'PageBlog',
      ),
      FIELDS => array('Page.id', 'Page.title'),
    ));

    $this->set(array(
      'comments' => $comments,
      'pageIds' => $pageIds,
    ));
  }

  private function __approve()
  {
    $count = 0;

    foreach (@$this->request->data['Comment']['id'] as $commentId) {
      $data = array(
        'id' => $commentId,
        'approved' => TRUE,
      );
      $r = $this->Comment->add($data, TRUE);
      if ($r === TRUE) $count++;
    }

    Baked::setFlash(__('%s件のコメントを承認しました', $count), 'success');
  }

  private function __unapprove()
  {
    $count = 0;

    foreach (@$this->request->data['Comment']['id'] as $commentId) {
      $data = array(
        'id' => $commentId,
        'approved' => FALSE,
      );
      $r = $this->Comment->add($data, TRUE);
      if ($r === TRUE) $count++;
    }

    Baked::setFlash(__('%s件のコメントを未承認にしました', $count), 'success');
  }

  private function __delete()
  {
    $count = 0;

    foreach (@$this->request->data['Comment']['id'] as $commentId) {
      $r = $this->Comment->delete($commentId);
      if ($r === TRUE) $count++;
    }

    Baked::setFlash(__('%s件のコメントを削除しました', $count), 'success');
  }

}









