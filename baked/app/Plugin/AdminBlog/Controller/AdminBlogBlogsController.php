<?php
App::uses('AppAdminBlogController', 'AdminBlog.Controller');

class AdminBlogBlogsController extends AppAdminBlogController
{
  public $uses = array('Page');

  public function listing()
  {
    $this->title = __('ブログ一覧');

    $this->paginate = $this->Page->getOptions(array(), array(
      CONDITIONS => array(
        'Page.package' => 'PageBlog',
      ),
      FIELDS => array(
        'Page.id', 'Page.name', 'Page.package', 'Page.title', 'Page.path', 'Page.data', 'Page.entries_count', 'Page.comments_count',
      ),
      'limit' => 20,
    ));
    $blogs = $this->paginate('Page');

    $this->set(array(
      'blogs' => $blogs,
    ));
  }

  public function settings($pageId = NULL)
  {
    $this->title = __('ブログ設定');

    $page = $this->Page->find('first', array(
      CONDITIONS => array(
        'Page.id' => $pageId,
        'Page.package' => 'PageBlog',
      ),
    ));
    if (empty($page)) $this->redirect('/admin/blog/blogs/listing');

    if ($this->request->data) {
      $this->Page->addLabelInValidate = FALSE;
      $r = $this->Page->updateData($pageId, $this->request->data['Page'], 'data');
      if ($r === TRUE) {
        Baked::setFlash(__('保存しました'), 'success');
        $this->redirect("/admin/blog/blogs/settings/{$pageId}");
      } else {
        Baked::setFlash(__('入力内容に不備があります'), 'error');
      }
    } else {
      $this->request->data['Page'] = $page['Page']['data'];
    }

    $this->set(array(
      'page' => $page,
    ));
  }

}









