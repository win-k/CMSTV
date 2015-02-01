<?php
App::uses('Controller', 'Controller');

class AppController extends Controller
{
  public $uses = array('System', 'Block');

  public function beforeFilter()
  {
    parent::beforeFilter();

    if (session_id() != '') {
      return;
      header('HTTP/1.0 404 Not Found');
      die('404 Not Found');
    }
    session_start();

    define('URL', Router::url('/'));
    $url = Router::url(array(), TRUE);
    define('CURRENT_URL', $url);
    define('EDITTING', (@$_SESSION['Staff']['Editmode'] === TRUE));

    if (defined('MY_CONFIGURED')) {
      define('BK_SITE_NAME', $this->System->value(System::KEY_SITE_NAME));
      $timezone = $this->System->value(System::KEY_TIMEZONE);
      if (!$timezone) $timezone = 'UTC';
      Baked::setTimezone($timezone);
    }

    $this->_setToken();
  }

  public function beforeRender()
  {
    parent::beforeRender();

    $this->set(array(
      'title' => $this->title,
    ));
  }

  private function _setToken()
  {
    if (empty($_SESSION['token'])) $_SESSION['token'] = getRandomString(32);
    $this->set(array(
      '_token' => $_SESSION['token'],
    ));
  }

  public function tokenFilterApi()
  {
    if (@$_SESSION['token'] !== @$this->request->data['token']) {
      $this->Api->ng(__('不正なトークンです。'));
    }
    return TRUE;
  }

  public function tokenFilter()
  {
    if (@$_SESSION['token'] !== @$this->request->data['token']) {
      die(__('不正なトークンです。'));
    }
    return TRUE;
  }

  public function staffFilterApi()
  {
    if (empty($_SESSION['Staff'])) $this->Api->ng(__('サインインしてください。'));
    return TRUE;
  }

  public function staffFilter()
  {
    if (empty($_SESSION['Staff'])) die(__('サインインしてください。'));
    return TRUE;
  }

/**
 * Get html of block.
 *
 * @param int $blockId
 * @return html
 */
  protected function _htmlBlock($blockId)
  {
    $block = $this->Block->find('first', array(
      CONDITIONS => array('Block.id' => $blockId),
    ));

    $this->uses[] = "{$block['Block']['package']}.{$block['Block']['package']}";
    $this->{$block['Block']['package']}->create();

    $view = new View();
    return $view->element('Baked/block', array(
      'block' => $block,
    ));
  }

}


