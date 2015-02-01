<?php
App::uses('AppAdminController', 'Controller');

class AdminSettingsGeneralController extends AppAdminController
{
  public $uses = array('System');

  public function input()
  {
    $this->title = __('基本設定');

    if ($this->request->data) {
      $this->tokenFilter();
      $r = $this->System->saveMultiply($this->request->data['System']);
      if ($r === TRUE) {
        Baked::setFlash(__('Saved the settings.'), 'success');
      } else {
        Baked::setFlash(__('There is a flaw in the input content.'), 'error');
      }
    } else {
      $this->request->data['System'] = array(
        System::KEY_SITE_NAME => $this->System->value(System::KEY_SITE_NAME),
        System::KEY_EMAIL     => $this->System->value(System::KEY_EMAIL),
        System::KEY_TIMEZONE  => $this->System->value(System::KEY_TIMEZONE),
        System::KEY_SITE_CAPTION  => Reception::read('site_caption'),
        System::KEY_COMPANY   => Reception::read('company'),
        System::KEY_ADDRESS   => Reception::read('address'),
        System::KEY_TEL       => Reception::read('tel'),
      );
    }

    Reception::read('address');
  }

}

