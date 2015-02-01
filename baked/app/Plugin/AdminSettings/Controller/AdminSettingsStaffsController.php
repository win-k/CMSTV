<?php
App::uses('AppAdminController', 'Controller');

class AdminSettingsStaffsController extends AppAdminController
{
  public $uses = array('Staff');

  public function index()
  {
    $this->title = __('管理者一覧');

    $staffs = $this->Staff->find('all', array(
      ORDER => array('Staff.created' => 'desc'),
      FIELDS => array(
        'Staff.id', 'Staff.email', 'Staff.name', 'Staff.created',
      ),
    ));

    $this->set(array(
      'staffs' => $staffs,
    ));
  }

  public function add($staffId = NULL)
  {
    $this->title = __('管理者詳細');

    if ($staffId) {
      $staff = $this->Staff->find('first', array(
        CONDITIONS => array('Staff.id' => $staffId),
        FIELDS => array(
          'Staff.id', 'Staff.email', 'Staff.name', 'Staff.created',
        ),
      ));
      if (empty($staff)) {
        Baked::setFlash(__('管理者が見つかりませんでした'), 'error');
        $this->redirect('/admin/settings/staffs');
      }
      $this->set('staff', $staff);
    }

    if ($this->request->data) {
      $this->tokenFilter();
      if (empty($this->request->data['Staff']['password'])) unset($this->request->data['Staff']['password']);
      if ($staffId) $this->request->data['Staff']['id'] = $staffId;
      $r = $this->Staff->addDataHavingPassword($this->request->data['Staff']);
      if ($r === TRUE) {
        Baked::setFlash(__('管理者情報を保存しました'), 'success');
        $this->redirect('/admin/settings/staffs');
      } else {
        Baked::setFlash(__('入力内容に不備があります'), 'error');
      }
    } else if ($staffId) {
      $this->request->data['Staff'] = $staff['Staff'];
    }
  }

}

