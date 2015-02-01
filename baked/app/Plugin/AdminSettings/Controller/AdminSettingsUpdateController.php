<?php
App::uses('AppAdminController', 'Controller');

class AdminSettingsUpdateController extends AppAdminController
{
  public $uses = array('System');

  public function index()
  {
    App::uses('BakedApi', 'Vendor');

    $newVersion = FALSE;
    $autoUpdate = FALSE;
    $dlUrl = FALSE;

    $bakedApi = new BakedApi;
    $r = $bakedApi->get('versions/check_update', array(
      'url' => Router::url('/', TRUE),
      'current_version' => BK_VERSION,
      'host' => gethostname(),
      'ip' => $_SERVER['REMOTE_ADDR'],
    ));
    if ($r === FALSE) {
      Baked::setFlash($bakedApi->error(), 'error');
    } else {
      if ($r['version'] > 0) {
        $newVersion = $r['version'];
        $autoUpdate = $r['auto_update'];
        $dlUrl = $r['dl_url'];
      }
    }

    $this->title = __('アップデート');

    $this->set(array(
      'newVersion' => $newVersion,
      'autoUpdate' => $autoUpdate,
      'dlUrl' => $dlUrl,
    ));
  }

  public function auto_update()
  {
    $this->tokenFilter();

    set_time_limit(180);
    ignore_user_abort(TRUE);

    App::uses('AutoUpdater', 'Vendor');
    $autoUpdater = new AutoUpdater;
    $autoUpdater->setTargetDirPath(ROOT);
    $autoUpdater->zipUrl = sprintf('http://%s/download/download/%s', OFFICIAL_HOST, $this->request->data['Update']['version']);
    $r = $autoUpdater->update();
    if ($r === TRUE) {
      Baked::setFlash(__('アップデートに成功しました'), 'success');
    } else {
      Baked::setFlash(__('アップデートエラー').' : '.$autoUpdater->error, 'error');
    }

    $this->redirect('/admin/settings/update');
  }

}

