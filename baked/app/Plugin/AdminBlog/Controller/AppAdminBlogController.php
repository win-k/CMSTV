<?php
App::uses('AppAdminController', 'Controller');

class AppAdminBlogController extends AppAdminController
{
  public $uses = array('Entry', 'Page');

  public function beforeFilter()
  {
    parent::beforeFilter();

    Baked::add('ADMIN_CSS', array(
      '/AdminBlog/css/style.css',
    ));
    Baked::add('ADMIN_JS', array(
      '/AdminBlog/js/AdminBlog.js',
      '/AdminBlog/js/interface.js',
    ));
  }

}









