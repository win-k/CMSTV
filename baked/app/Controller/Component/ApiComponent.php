<?php
App::uses('Component', 'Controller');

/**
 * API通信におけるデータ返却用クラス
 *
 * ApiComponentは、リクエストに対して適切にデータを整形し、返却するためのコンポーネントです。
 *
 * @package       app.Controller.Component
 * @author        Masayuki Akiyama
 */

class ApiComponent extends Component
{
  // 出力するデータ
  private $_data = NULL;

  // 出力データに不可するステータスデータ
  // API自体の成功・不成功を示す
  private $_api = array('status' => 'OK');

  public function ok()
  {
    $args = func_get_args();

    $array = array(
      'result' => 'OK',
    );

    array_walk_recursive($args, function (&$item) {
      if ($item === TRUE) {
        $item = 1;
        return;
      }
      if ($item === FALSE) {
        $item = 0;
        return;
      }
      if ($item === NULL) {
        $item = '';
        return;
      }
    });

    foreach ($args as $arg) {
      if (empty($arg) && ($arg != '0')) continue;
      if (is_string($arg)) $arg = array('id' => $arg);
      $array += $arg;
    }

    $this->ret($array);
  }

  public function ng($errorMsg = NULL, $code = 0)
  {
    $ret = array(
      'code' => $code,
      'result' => 'NG',
    );
    if (is_array($errorMsg)) {
      $ret += $errorMsg;
    } else {
      $ret['message'] = $errorMsg;
    }

    $this->ret($ret);
  }

/**
 * $dataに配列を代入
 * @param array $dataToSet
 */
  public function set($data)
  {
    $this->_data = $data;
  }

/**
 * データをjson形式にエンコードし、適切なヘッダーと共に出力します。その後、スクリプトの実行を終了します。
 *
 * @param array $data
 * @param array $api
 */
  public function ret($data = NULL, $api = NULL)
  {
    if (!is_null($data)) { $this->_data = $data; }
    if (!is_null($api)) { $this->_api = $api; }

    $this->_data['_api'] = $this->_api;

    header('Content-Type: application/json; charset=utf-8');
    $s = json_encode($this->_data);
    echo $s;
    exit;
  }

}
