<?php
class AdminThemesApiController extends AdminThemesAppController
{
  public $uses = array('ThemePackage');
  public $components = array('Api');

  public function beforeFilter()
  {
    parent::beforeFilter();

    $this->staffFilterApi();
    $this->tokenFilterApi();
  }

  public function check_plugin_exists()
  {
    $r = Baked::installedPlugin(@$this->request->data['plugin']);
    $result = array(
      'exists' => $r,
    );
    if ($r) $result['message'] = __d('AdminThemes', '選択したテーマは既にインストール済みです。上書きしてインストールしますか？');
    $this->Api->ok($result);
  }

  public function extract_zip()
  {
    $r = $this->ThemePackage->extractZip($this->request->data['zip'], $this->request->data['plugin'], $pluginPath);
    if ($r !== TRUE) $this->Api->ng($r->getMessage());

    $this->Api->ok(array(
      'pluguinPath' => $pluginPath,
    ));
  }

  public function install()
  {
    $r = Baked::renamePlugin(@$this->request->data['plugin_path'], NULL, $error);
    if ($r !== TRUE) $this->Api->ng($error);

    Baked::deleteAllCache();
    $this->Api->ok(array(
      'message' => __d('AdminThemes', '正常にインストールされました'),
    ));
  }

}

