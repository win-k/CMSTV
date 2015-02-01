<?php
App::uses('AppAdminController', 'Controller');

class AdminThemesAppController extends AppAdminController
{
  public function beforeFilter()
  {
    parent::beforeFilter();

    Baked::add('ADMIN_CSS', array('/AdminThemes/css/style.css'));
    Baked::add('ADMIN_JS', array(
      '/AdminThemes/js/class/AdminThemes.js',
      '/AdminThemes/js/interface/adminThemes.js',
    ));
  }

}
