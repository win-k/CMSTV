<?php
class AdminThemesGeneralController extends AdminThemesAppController
{
  public $uses = array('ThemePackage', 'System');

  public function installed()
  {
    $this->title = __('インストール済みテーマ');

    $themePackages = $this->ThemePackage->installed();

    if (!empty($this->request->data['ThemePackage']['mode'])
      && !empty($this->request->data['ThemePackage']['plugin'])
    ) {
      $this->tokenFilter();
      try {
        if ($this->request->data['ThemePackage']['mode'] === 'set_pc') {
          $r = $this->ThemePackage->setUsed($this->request->data['ThemePackage']['plugin'], 'pc');
          if ($r !== TRUE) throw $r;
          Baked::setFlash(__('PC用テーマに設定しました'), 'success');
        } elseif ($this->request->data['ThemePackage']['mode'] === 'set_mobile') {
          $r = $this->ThemePackage->setUsed($this->request->data['ThemePackage']['plugin'], 'mobile');
          if ($r !== TRUE) throw $r;
          Baked::setFlash(__('モバイル用テーマに設定しました'), 'success');
        } elseif ($this->request->data['ThemePackage']['mode'] === 'delete') {
          $r = $this->ThemePackage->remove($this->request->data['ThemePackage']['plugin']);
          if ($r !== TRUE) throw $r;
          Baked::setFlash(__('テーマを削除しました'), 'success');
        }

        $this->redirect('/admin/themes/general/installed');
      } catch (Exception $e) {
        Baked::setFlash($r->getMessage(), 'error');
      }
    }

    $this->set(array(
      'themePackages' => $themePackages,
      'useTheme' => $this->System->value(System::KEY_USE_THEME),
      'useThemeMobile' => $this->System->value(System::KEY_USE_THEME_MOBILE),
    ));
  }

  public function edit_pc()
  {
    $this->title = __('PCテーマの編集');

    $this->__setupForEdit('pc');
  }

  public function edit_mobile()
  {
    $this->title = __('モバイルテーマの編集');

    $this->__setupForEdit('mobile');
  }

  private function __setupForEdit($type)
  {
    $key = ($type == 'pc') ? System::KEY_USE_THEME : System::KEY_USE_THEME_MOBILE ;
    $plugin = $this->System->value($key);
    $themeInfo = Configure::read("Themes.{$plugin}");
    if (empty($themeInfo)) {
      Baked::setFlash(__('Cannot find the theme.'), 'error');
      $this->redirect('/admin/themes/general/installed');
    }

    $openFile = urldecode(@$this->request->query['file']);

    $path = APP."Plugin/{$plugin}";
    App::uses('Folder', 'Utility');
    $folder = new Folder();
    $trees = $folder->tree($path, TRUE, 'file');

    $files = array();
    foreach ($trees as $tree) {
      $ext = extensionByFilename($tree);
      if (!in_array($ext, array('php', 'ctp', 'css', 'js', 'cgi', 'pl', 'txt', 'html', 'htm'))) continue;
      $file = str_replace($path, '', $tree);
      $tmp = array(
        'path' => $tree,
        'file' => $file,
      );
      $files[] = $tmp;

      if (@$openFile == $file) $this->set('currentFile', $tmp);
    }

    if ($this->request->data) {
      $this->tokenFilter();

      $r = $this->ThemePackage->write($this->request->data['Editor']['path'], $this->request->data['Editor']['file']);
      if ($r === TRUE) {
        Baked::setFlash(__('ファイルの編集を保存しました'), 'success');
      } else {
        Baked::setFlash($r->getMessage(), 'error');
      }
    }

    $this->set(array(
      'themeInfo' => $themeInfo,
      'files' => $files,
    ));
  }

}


















