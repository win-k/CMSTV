<?php
App::uses('AppController', 'Controller');

class SetupController extends AppController
{
  public $uses = array('Validator', 'Staff');
  public $layout = 'setup';
  const SESSION_DATABASE = 'setup_database';
  const SESSION_SITE = 'setup_site';
  const SESSION_STAFF = 'setup_staff';

  public function beforeFilter()
  {
    parent::beforeFilter();
  }

  public function beforeRender()
  {
    parent::beforeRender();

    if (defined('MY_CONFIGURED')) $this->redirect('/');
  }

  private function __checkRequirements(&$environemtns = NULL)
  {
    $requirements = Baked::getRequirements();

    $environemtns = array();
    $error = FALSE;

    // PHPバージョン
    $phpversion = phpversion();
    if ($phpversion < $requirements['php']) {
      $environemtns['PHP'] = __('PHP バージョン %s 以上が必要です', $requirements['php']);
      $error = TRUE;
    } else {
      $environemtns['PHP'] = TRUE;
    }

    // GD
    if (!function_exists('gd_info')) {
      $environemtns['GD'] = __('php-gd モジュールが必要です');
      $error = TRUE;
    } else {
      $environemtns['GD'] = TRUE;
    }

    // パーミッション

    if (!$error) return TRUE;

    return FALSE;
  }

  private function __checkRequirementsFilter()
  {
    if (!$this->__checkRequirements()) $this->redirect('/system/setup/start');
  }

  private function __hasDatabaseFilter()
  {
    if (empty($_SESSION[self::SESSION_DATABASE])) $this->redirect('/system/setup/database');
  }

  private function __hasSiteFilter()
  {
    if (empty($_SESSION[self::SESSION_SITE])) $this->redirect('/system/setup/site');
  }

  private function __hasStaffFilter()
  {
    if (empty($_SESSION[self::SESSION_STAFF])) $this->redirect('/system/setup/staff');
  }

  private function __validDatabase($db)
  {
    try {
      $connect = @new mysqli($db['host'], $db['user'], $db['password'], $db['name']);
      if ($connect->connect_errno)
        throw new Exception(__('データベースに接続できませんでした (%s)', $connect->connect_error));
      $connect->close();

      return TRUE;
    } catch (Exception $e) {
      return FALSE;
    }
  }

  private function __makeConfig()
  {
    try {
      $configTemplate = @file_get_contents(APP.'Config/my.template.txt');
      if (!$configTemplate) throw new Exception(__('設定用テンプレートファイルが見つかりませんでした'));

      foreach ($_SESSION[self::SESSION_DATABASE] as $key => $value) {
        $key = "db_{$key}";
        $configTemplate = str_replace(sprintf('<:%s>', $key), $value, $configTemplate);
      }

      $securitySalt = getRandomString(32);
      $configTemplate = str_replace('<:security_salt>', $securitySalt, $configTemplate);
      $securityCiperseed = getRandomString(16, TRUE);
      $configTemplate = str_replace('<:security_ciperseed>', $securityCiperseed, $configTemplate);

      $myConfPath = ROOT.'/my.php';
      $fp = @fopen($myConfPath, 'w');
      if (!$fp) throw new Exception(__('設定ファイルに書き込みできませんでした。"%s"のパーミッションを確認してください', $myConfPath));
      fwrite($fp, $configTemplate);
      fclose($fp);

      return TRUE;
    } catch (Exception $e) {
      return $e;
    }
  }

  private function __importDatabase()
  {
    try {
      $sqlPath = APP.'Config/baked.sql';
      $sql = file_get_contents($sqlPath);
      $sql = $this->__filterQuery($sql);
      if (!$sql) throw new Exception(__('SQLファイルが見つかりませんでした'));

      $db = $_SESSION[self::SESSION_DATABASE];
      $connect = new mysqli($db['host'], $db['user'], $db['password'], $db['name']);
      if ($connect->connect_errno)
        throw new Exception(__('データベースに接続できませんでした (%s)', $connect->connect_error));
      $connect->multi_query($sql);
      if ($connect->errno)
        throw new Exception(__('クエリの実行に失敗しました (%s)', $connect->error));
      $connect->close();

      Baked::deleteAllCache();

      sleep(2);

      $r = $this->Staff->addDataHavingPassword($_SESSION[self::SESSION_STAFF], FALSE);
      if ($r !== TRUE) throw $r;

      $systemData = $_SESSION[self::SESSION_SITE];
      $systemData['email'] = $_SESSION[self::SESSION_STAFF]['email'];
      $systemData['use_theme'] = 'ThemeCleanPaperOrange';
      $systemData['use_theme_mobile'] = 'ThemeJanuary';
      $systemData['timezone'] = 'Asia/Tokyo';
      $r = $this->System->saveMultiply($systemData);
      if ($r !== TRUE) throw $r;

      return TRUE;
    } catch (Exception $e) {
      return $e;
    }
  }

  private function __filterQuery($sql)
  {
    $sql = str_replace('<:url>', URL, $sql);
    return $sql;
  }

  public function start()
  {
    $this->title = __('必要要件');
    $environemtns;

    if ($this->__checkRequirements($environemtns)) {
      $this->redirect('/system/setup/db');
    }

    $this->set(array(
      'environemtns' => $environemtns,
    ));
  }

  public function db()
  {
    $this->__checkRequirementsFilter();
    $this->title = __('DB設定');

    if ($this->request->data) {
      try {
        $r = $this->Validator->add($this->request->data['Validator'], null, 'database', Validator::VALIDATION_MODE_ONLY);
        if ($r !== TRUE) throw new Exception(__('入力内容に不備があります'));

        if (!$this->__validDatabase($this->request->data['Validator']))
          throw new Exception(__('データベースへの接続に失敗しました。設定が正しいかどうか、確認してください。'));

        $_SESSION[self::SESSION_DATABASE] = $this->request->data['Validator'];

        $this->redirect('/system/setup/site');
      } catch (Exception $e) {
        Baked::setFlash($e->getMessage(), 'error');
      }
    } else if (!empty($_SESSION[self::SESSION_DATABASE])) {
      $this->request->data['Validator'] = $_SESSION[self::SESSION_DATABASE];
    }
  }

  public function site()
  {
    $this->__checkRequirementsFilter();
    $this->__hasDatabaseFilter();

    $this->title = __('サイト設定');

    if ($this->request->data) {
      try {
        $r = $this->Validator->add($this->request->data['Validator'], FALSE, 'site', Validator::VALIDATION_MODE_ONLY);
        if ($r !== TRUE) throw new Exception(__('入力内容に不備があります'));

        $_SESSION[self::SESSION_SITE] = $this->request->data['Validator'];
        if ($r !== TRUE) throw $r;

        $this->redirect('/system/setup/staff');
      } catch (Exception $e) {
        Baked::setFlash($e->getMessage(), 'error');
      }
    } else if (!empty($_SESSION[self::SESSION_SITE])) {
      $this->request->data['Validator'] = $_SESSION[self::SESSION_SITE];
    }
  }

  public function staff()
  {
    $this->__checkRequirementsFilter();
    $this->__hasDatabaseFilter();
    $this->__hasSiteFilter();

    $this->Staff->useTable = FALSE;

    $this->title = __('管理者設定');

    if ($this->request->data) {
      try {
        $r = $this->Staff->add($this->request->data['Staff'], FALSE, 'first_add', Staff::VALIDATION_MODE_ONLY);
        if ($r !== TRUE) throw new Exception(__('入力内容に不備があります'));

        $_SESSION[self::SESSION_STAFF] = $this->request->data['Staff'];

        $r = $this->__makeConfig();
        if ($r !== TRUE) throw $r;

        $this->redirect('/system/setup/import_database');
      } catch (Exception $e) {
        Baked::setFlash($e->getMessage(), 'error');
      }
    } else if (!empty($_SESSION[self::SESSION_STAFF])) {
      $this->request->data['Staff'] = $_SESSION[self::SESSION_STAFF];
    }
  }

  public function import_database()
  {
    $this->__checkRequirementsFilter();
    $this->__hasDatabaseFilter();
    $this->__hasSiteFilter();
    $this->__hasStaffFilter();

    $r = $this->__importDatabase();
    if ($r !== TRUE) {
      Baked::setFlash($r->getMessage(), 'error');
      $this->redirect('/system/setup/staff');
    }

    $this->redirect('/system/setup/done');
  }

  public function done()
  {
    $this->__checkRequirementsFilter();
    $this->__hasDatabaseFilter();
    $this->__hasSiteFilter();
    $this->__hasStaffFilter();

    $this->title = __('インストール完了');

    if (!defined('MY_CONFIGURED')) {
      $myConfPath = ROOT.'/my.php';
      $fp = @fopen($myConfPath, 'a');
      if (!$fp) throw new Exception(__('設定ファイルに書き込みできませんでした。ディレクトリ"%s"のパーミッションを確認してください', ROOT));
      fwrite($fp, sprintf("define('MY_CONFIGURED', TRUE);"));
      fclose($fp);
    }
  }

}
























