<?php
/**
 * @link http://www.exgear.jp/blog/2009/06/cakephp-behavior%E3%81%A7%E3%83%90%E3%83%AA%E3%83%87%E3%83%BC%E3%82%B7%E3%83%A7%E3%83%B3%E5%91%A8%E3%82%8A%E3%81%AE%E5%8A%B9%E7%8E%87%E5%8C%96%E3%82%92%E5%9B%B3%E3%82%8B/
 */
class BasicValidationBehavior extends ModelBehavior
{
  public $loaded = false;
  public $autoConvert = true;
  public $convert = array();

  #########################################################################
  /**
   * エラーメッセージ
   */
  #########################################################################
  public $validateMessage = array(
    // 標準バリデーション
    'alphaNumeric'  => '半角英数字で入力してください',
    'between'       => '%s文字以上%2s文字以内の半角文字を入力してください',
    'blank'         => '空でなければなりません',
    'cc'            => 'クレジットカード番号として正しくありません',
    'custom'        => '入力値が正しくありません',
    'date'          => '日付形式で入力してください:1',
    'datetime'      => '日付形式で入力してください:2',
    'decimal'       => '小数点第%s位までの半角数字を入力してください。',
    'email'         => 'メールアドレスが不正です',
    'equalTo'       => '入力値が%sと一致しません',
    'extension'     => '拡張子が正しくありません',
    'ip'            => 'IPアドレス形式で入力してください',
    'minLength'     => '%sバイト文字以上で入力してください',
    'maxLength'     => '%sバイト文字以内で入力してください',
    'money'         => '入力値が正しくありません',
    'numeric'       => '半角数字で入力してください',
    'phone'         => '電話番号形式で入力してください',
    'postal'        => '郵便番号形式で入力してください',
    'range'         => '%sより大きく%sより小さい半角数字を入力してください',
    'url'           => 'URL形式で入力してください',
    'isUnique'      => 'この値は既に登録済です',
    'inList'        => '入力値が正しくありません',
    'time'          => '時:分 形式で入力してください',
    'notEmpty'      => '入力してください',

    // 拡張バリデーション
    'valid_required'    => '入力してください',
    'valid_isEqual'     => '正常に値ではありません',
    'valid_maxLen'      => '入力された文字数が制限を越えています(最大%s文字)',
    'valid_minLen'      => '入力された文字数が制限未満です(最小%s文字)',
    'valid_equalLen'    => '入力された文字数が正しくありません(%s文字で入力してください)',
    'valid_phone'       => '半角数字とハイフン(-)で入力してください',
    'valid_phone'       => '電話番号形式で入力してください',
    'valid_zip'         => '郵便番号形式(3桁-4桁)で入力してください',
    'valid_zen'         => '全角以外の文字が含まれています',
    'valid_kana'        => 'カタカナ以外の文字が含まれています',
    'valid_hirakana'    => 'ひらかな以外の文字が含まれています',
    'valid_single'      => '半角以外の文字が含まれています',
    'valid_confirm'     => '入力内容が一致しません',
    'valid_greaterThan' => '値が小きすぎます',
    'valid_lessThan'    => '値が大さすぎます',
    'valid_email'       => 'メールアドレスが不正です',
    'valid_emailMulti'  => 'メールアドレスが不正です',
    'valid_ymd'         => '正しい日付形式で入力してください',
    'valid_jis'         => '環境依存文字・旧漢字はご利用頂けません',
    'valid_isUniqueWithStatus'  => 'この値は既に登録済です',
    'valid_isUniqueLogically'   => 'この値は既に登録済です',
    'valid_isExistLogically'    => 'この値は存在しません',
    'valid_isExistLogicallyWithParams' => '許可されていないアクセスを検知しました',
    'valid_isUniqueWithParams' => '既に登録済みです',
    'valid_isExist'     => 'この値は存在しません',
    'valid_inClassArrayKeys'     => 'この値は存在しません',
    'valid_int'         => '半角数字で入力してください',
    'valid_positive_number' => '整数で入力してください',
    'valid_upload'      => 'ファイルを選択して下さい',
    'valid_array_having_values' => '入力数が少なすぎます(最小%s個)',
    'valid_date_range'  => '%sから%sの間で入力してください',
    'valid_justLen'     => '%s文字で入力してください',
    'valid_dateLaterToday' => '本日以降の日時を選択してください',
    'valid_available'   => '使用できない文字列です',
  );


  #########################################################################
  /**
   * データ整形用にカラムとルールの対応を保存
   */
  #########################################################################
  function SetConvert(&$model, $col, $rule)
  {
    $this->convert[][$col] = $rule;
  }

  #########################################################################
  /**
   * バリデーション定義毎のデータ整形
   */
  #########################################################################
  function convertData(&$model, $col, $rule)
  {
    $before = '';
    $after = '';
    if (isset($model->data[$model->name]) && isset($model->data[$model->name][$col])) {
      $before = $model->data[$model->name][$col];
      $after = $model->data[$model->name][$col] = $this->_convert($before, $rule);
    }
    elseif (isset($model->data[$col])) {
      $before = $model->data[$col];
      $after = $model->data[$col] = $this->_convert($model->data[$col], $rule);
    }
  }

  function _convert($v, $rule) {
    if ($v == '') return $v;
    switch($rule) {
      case 'alphaNumeric':
      case 'email':
      case 'date':
      case 'ip':
      case 'numeric':
      case 'url':
      case 'time':
      case 'valid_single':
      case 'valid_email':
      case 'valid_emailMulti':
        // 1バイト文字
        $v = mb_convert_kana($v, 'ras');
        break;

      case 'valid_zen':
        // 全角文字
        $v = mb_convert_kana($v, 'ASKV');
        break;

      case 'valid_kana':
        // 全角カタカナ文字
        $v = mb_convert_kana($v, 'KVC');
        break;

      case 'valid_hirakana':
        // 全角ひらかな文字
        $v = mb_convert_kana($v, 'HVc');
        break;

      case 'valid_phone':
        $v = mb_convert_kana($v, 'ras');
        $v = str_replace(array('ー','―','‐'), '-', $v);
        break;

      case 'valid_zip':
        $v = mb_convert_kana($v, 'ras');
        $v = str_replace(array('ー','―','‐'), '-', $v);
        if(strlen($v) == 7 && preg_match("/^[0-9]+$/", $v)){
            $v = substr($v,0,3) . '-' . substr($v,3);
        }
        break;

      case 'valid_ymd':
        $v = mb_convert_kana($v, 'ras');
        $v = str_replace('/', '-', $v);
        break;
    }
    return $v;
  }

  #########################################################################
  /**
   * 必須項目の出力文字列設定
   */
  #########################################################################
  public $require_string = '';
  function setRequireString(&$model, $str)
  {
    $this->require_string = $str;
  }

  #########################################################################
  /**
   * 必須項目の場合は設定文字列を返す
   */
  #########################################################################
  function getRequireString(&$model, $col)
  {
    // バリデーション定義の読み込み
    #if (method_exists($model, 'loadValidate') && !$this->loaded) {
    if (method_exists($model, 'loadValidate')) {
      $model->loadValidate();
      $this->loaded = TRUE;
    }
    if (!isset($model->validate[$col])) return '';
    if ($this->_getArrayValueRecursive('required', $model->validate[$col])) {
      return $this->require_string;
    }
    return '';
  }

  #########################################################################
  /**
   * 配列にキーが存在していればその値を返す
   */
  #########################################################################
  function _getArrayValueRecursive($strKey, $arrArray)
  {
    $ret = false;
    while ( list($key, $value) = each($arrArray)) {
      $ret = $key === $strKey ? $value : false;
      if (is_array($value) && ! $ret) {
        $ret = $this->_getArrayValueRecursive($strKey, $value);
      }
      if ($ret) break;
    }
    return $ret;
  }

  #########################################################################
  /**
   * バリデーションの実行前に初期化を行う
   */
  #########################################################################
  function beforeValidate(Model $Model)
  {
    #if (method_exists($Model, 'loadValidate') && !$this->loaded){
    if (method_exists($Model, 'loadValidate')){
      $Model->loadValidate();
      $this->loaded = TRUE;
    }

    // 整形処理実行
    if ($this->autoConvert) {
      foreach($this->convert as $i => $arr){
        list($col, $rule) = each($arr);
        $this->convertData($Model, $col, $rule);
      }
    }

    return TRUE;
  }

  #########################################################################
  /**
   * バリデーション配列を引数の共通項のみとする
   */
  #########################################################################
  function intersectValidate(&$model, $arg)
  {
    if (method_exists($model, 'loadValidate')) {
      $model->loadValidate();
      $this->loaded = TRUE;
    }
    if (is_scalar($arg)) {
      // for 'colA,colB'
      $okVali = array_flip(explode(',', $arg));
    } else {
      if (isset($arg[$model->name])) {
        // for normal $data[model][colA]="xxx"
        $okVali = $arg[$model->name];
      } else {
        $cnt = Set::countDim($arg);
        // for saveAll $data[23][colA]="xxx"
        if ($cnt == 2) {
          $okVali = array_shift($arg);
        } else {
          list($col1, $col2) = each($arg);
          if (is_integer($col1)) {
            // for columnArray array('colA', 'colB')
            $okVali = array_flip($arg);
          } else {
            // for columnKeyArray array('colA'=>"xxx", 'colB'=>"yyy")
            $okVali = $arg;
          }
        }
      }
    }
    $model->validate = array_intersect_key($model->validate, $okVali);
  }

  #########################################################################
  /**
   * バリデーションの展開
   */
  #########################################################################
  function setValidate(&$model, $arr)
  {
    foreach ($arr as $col => $validate) {
      $validate = str_replace(" ", "", $validate);
      $validate = trim($validate, '|');
      $vali_arr = explode('|', $validate);

      foreach ($vali_arr as $rule) {
        // 必須項目判定
        if ($rule == 'required') {
          $allowEmpty = FALSE;
          $required   = TRUE;
          /*
          // 必須メッセージは優先表示（最後に再設定）
          $tmp = array_flip($vali_arr);
          unset($tmp['required']);
          $vali_arr = array_flip($tmp);
          $vali_arr[] = 'required';
          */
        } else if ($rule == 'notEmpty') {
          $allowEmpty = FALSE;
          $required   = FALSE;
        } else {
          $allowEmpty = TRUE;
          $required   = FALSE;
        }

        $param = "";
        $isParamArray = false;
        if (preg_match("/(.*?)\((.*?)\)/", $rule, $match)) {
          $rule   = $match[1];
          $param  = $match[2];
          $isParamArray = true;
        }
        else if (preg_match("/(.*?)\[(.*?)\]/", $rule, $match)) {
          $rule   = $match[1];
          $param  = $match[2];
        }
        if (method_exists($this, 'valid_' . $rule)) {
          $rule = 'valid_' . $rule;
        }
        $msg  = '';
        if (isset($this->validateMessage[$rule])) {
          $msg = $this->validateMessage[$rule];
        } else {
          $msg = $rule;
        }
        if ($param && strstr($msg, '%s')) {
          $tmp_p = array();
          foreach (explode(',', $param) as $_p) {
            $tmp_p[] = trim($_p);
          }
          $msg = vsprintf($msg, $tmp_p);
        }

        // 項目ラベルを表示する場合
        $label = $col;
        if (method_exists($model, 'getLabel')) {
          if (!($label = $model->getLabel($col))) {
            $label = $col;
          }
        }
        if (strstr($msg, '{%label%}')) {
          $msg = str_replace('{%label%}', $label, $msg);
        }

        // 項目がリスト型の場合、文言を変更する
        if ($model->Behaviors->attached('List')) {
          $list = $model->getList($col);
          if ($rule == 'valid_required' && !empty($list)) {
            $msg = str_replace('入力', '選択', $msg);
          }
        }

        $my_rule = $rule;
        if ($param != '') {
          $my_rule = array($rule);
          if ($isParamArray === true) {
            $tmp = array();
            foreach (explode(',', $param) as $p) {
              $tmp[] = trim($p);
            }
            $my_rule[] = $tmp;
          } else {
            foreach (explode(',', $param) as $p) {
              $my_rule[] = trim($p);
            }
          }
        }
        $model->validate[$col][$rule] = array(
          'rule'       => $my_rule,
          'message'    => $msg,
          'required'   => $required,
          'allowEmpty' => $allowEmpty,
          //'last' => true,
        );
        // 整形セット
        $this->SetConvert($model, $col, $rule);
      }
    }

    $this->loaded = TRUE;
  }

  #########################################################################
  /**
   * メッセージのカスタマイズ
   */
  #########################################################################
  function setMessage(&$model, $col, $rule, $message)
  {
    if (method_exists($this, 'valid_' . $rule)){
      $rule = 'valid_' . $rule;
    }
    if (isset($model->validate[$col]) && isset($model->validate[$col][$rule])) {
      $model->validate[$col][$rule]['message'] = $message;
    }
  }

  #########################################################################
  /**
   * バリデーションのクリア
   */
  #########################################################################
  function clearValidate(&$model)
  {
    $this->loaded = TRUE;
    $model->validate = array();
    $this->convert = array();
  }

  #########################################################################
  /**
   * 必須項目チェック
   */
  #########################################################################
  function valid_required(&$model, $data)
  {
    list($k, $v) = each($data);

    // ファイルの場合
    if (is_array($v) && array_key_exists('tmp_name', $v)) {
      if ($v['size'] > 0) return TRUE;
      return FALSE;
    }

    // 配列の場合(チェックボックス用)
    if (is_array($v)) {
      foreach ($v as $arr_v) {
        if ($arr_v) return TRUE;
      }
      return FALSE;
    }

    if (!isset($v) || ($v == '')) {
      return FALSE;
    } else {
      return TRUE;
    }
  }

  #########################################################################
  /**
   * 等価チェック
   */
  #########################################################################
  function valid_isEqual(&$model, $data, $val)
  {
    list($k, $v) = each($data);
    if (is_array($v)) list($k, $v) = each($v);
    if ($v === '') return TRUE;

    return ($v == $val);
  }

  #########################################################################
  /**
   * 最大文字数チェック
   */
  #########################################################################
  function valid_maxLen(&$model, $data, $len)
  {
    list($k, $v) = each($data);

    if (mb_strlen(str_replace("\r\n", "\n", $v)) > $len) {
      return FALSE;
    } else {
      return TRUE;
    }
  }

  #########################################################################
  /**
   * 最少文字数チェック
   */
  #########################################################################
  function valid_minLen(&$model, $data, $len)
  {
    list($k, $v) = each($data);
    if (mb_strlen(str_replace("\r\n", "\n", $v)) < $len) {
       return FALSE;
    } else {
      return TRUE;
    }
  }
  #########################################################################
  /**
   * 文字数一致チェック
   */
  #########################################################################
  function valid_equalLen(&$model, $data, $len)
  {
    list($k, $v) = each($data);
    if (mb_strlen(str_replace("\r\n", "\n", $v)) != $len) {
      return FALSE;
    } else {
      return TRUE;
    }
  }

  #########################################################################
  /**
   * 電話番号簡易チェック
   */
  #########################################################################
  function valid_phone_easy(&$model, $data)
  {
    list($k, $v) = each($data);
    if ($v === '') return TRUE;

    if (preg_match("/^[\d-]*$/", $v)) {
      return TRUE;
    } else {
      return FALSE;
    }
  }

  #########################################################################
  /**
   * 電話番号チェック
   */
  #########################################################################
  function valid_phone(&$model, $data)
  {
    list($k, $v) = each($data);
    if ($v === '') return TRUE;

    if (preg_match("/^\d{2,5}\-\d{1,4}\-\d{1,4}$/", $v)) {
      return TRUE;
    } else {
      return FALSE;
    }
  }

  #########################################################################
  /**
   * 郵便番号チェック
   */
  #########################################################################
  function valid_zip(&$model, $data)
  {
    list($k, $v) = each($data);
    if ($v === '') return TRUE;

    if (preg_match("/^\d{3}\-\d{4}$/", $v)) {
      return TRUE;
    } else {
      return FALSE;
    }
  }

  #########################################################################
  /**
   * 全角チェック
   */
  #########################################################################
  function valid_zen(&$model, $data)
  {
    list($k, $v) = each($data);
    if ($v === '') return TRUE;
    $v = mb_convert_encoding($v, 'UTF-8');
    if (!preg_match("/(?:\xEF\xBD[\xA1-\xBF]|\xEF\xBE[\x80-\x9F])|[\x20-\x7E]/", $v)) {
      return TRUE;
    }
    return FALSE;
  }

  #########################################################################
  /**
   * カタカナチェック
   */
  #########################################################################
  function valid_kana(&$model, $data)
  {
    list($k, $v) = each($data);
    if ($v === '') return TRUE;

    $v = mb_convert_encoding($v, 'UTF-8');
    if (preg_match("/^(?:\xE3\x82[\xA1-\xBF]|\xE3\x83[\x80-\xB6]|ー)+$/", $v)) {
      return TRUE;
    }
    return FALSE;
  }

  #########################################################################
  /**
   * ひらかなチェック
   */
  #########################################################################
  function valid_hirakana(&$model, $data)
  {
    list($k, $v) = each($data);
    if ($v === '') return TRUE;
    $v = mb_convert_encoding($v, 'UTF-8');
    if (preg_match("/^(?:\xE3\x81[\x81-\xBF]|\xE3\x82[\x80-\x93])+$/", $v)) {
      return TRUE;
    }
    return FALSE;
  }

  #########################################################################
  /**
   * 環境依存文字・旧漢字などJISに変換できない文字チェック
   */
  #########################################################################
  function valid_jis(&$model, $data)
  {
    list($k, $v) = each($data);
    if ($v === '') return TRUE;
    $myEnc = Configure::read('App.encoding');
    // 対象外
    $v = str_replace(array('～', 'ー', '－', '∥', '￠', '￡', '￢'), "", $v);
    $v2 = mb_convert_encoding($v, 'iso-2022-jp', $myEnc);
    $v2 = mb_convert_encoding($v2, $myEnc,'iso-2022-jp');
    if ($v == $v2) {
      return TRUE;
    }
    return FALSE;
  }

  #########################################################################
  /**
   *  1バイト文字列チェック
   */
  #########################################################################
  function valid_single(&$model, $data)
  {
    list($k, $v) = each($data);
    if ($v === '') return TRUE;

    if (strlen($v) != mb_strlen($v)){
      return FALSE;
    }
    return TRUE;
  }

  #########################################################################
  /**
   *  確認入力用
   */
  #########################################################################
  function valid_confirm(&$model, $data, $col )
  {
    list($k, $v) = each($data);
    if (!isset($model->data[$model->name][$col])){
      return FALSE;
    }
    if ($v === $model->data[$model->name][$col]){
      return TRUE;
    }
    return FALSE;
  }

  #########################################################################
  /**
   *  大なり
   */
  #########################################################################
  function valid_greaterThan(&$model, $data, $col, $acceptEqual = 1)
  {
    list($k, $v) = each($data);

    if (!isset($model->data[$model->name][$col])){
        return FALSE;
    }
    if (($v > $model->data[$model->name][$col]
      || ($acceptEqual == 1 && $v == $model->data[$model->name][$col])
    )) {
      return TRUE;
    }
    return FALSE;
  }

  #########################################################################
  /**
   *  小なり
   */
  #########################################################################
  function valid_lessThan(&$model, $data, $col, $acceptEqual = 1)
  {
    list($k, $v) = each($data);
    if (!isset($model->data[$model->name][$col])) {
      return FALSE;
    }
    if (($v < $model->data[$model->name][$col]
      || ($acceptEqual == 1 && $v == $model->data[$model->name][$col])
    )) {
      return TRUE;
    }
    return FALSE;
  }

  #########################################################################
  /**
   *  メールアドレス妥当性チェック
   */
  #########################################################################
  function valid_email(&$model, $data )
  {
    list($k, $v) = each($data);
    if ($v === '') return TRUE;

    $__pattern = '(?:[a-z0-9][-a-z0-9]*\.)*(?:[a-z0-9][-a-z0-9]{0,62})\.(?:(?:[a-z]{2}\.)?[a-z]{2,4}|museum|travel)';
    $__regex   = '/^[a-z0-9!#$%&\'*+\/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&\'*+\/=?^_`{|}~-]+)*@' . $__pattern . '$/i';

    if (preg_match($__regex, $v)) {
      return true;
    } else {
      return false;
    }
  }

  #########################################################################
  /**
   *  メールアドレス妥当性チェック(複数カンマ区切り)
   */
  #########################################################################
  function valid_emailMulti(&$model, $data )
  {
    list($k, $v) = each($data);
    if ($v === '') return TRUE;

    $mails = explode(',', $v);
    foreach ($mails as $m) {
      $myData = array($k=>$m);
      if (!$this->valid_email($model, $myData)) {
        return FALSE;
      }
    }
    return TRUE;
  }

  #########################################################################
  /**
   *  YYYY-MM-DD形式かどうか
   */
  #########################################################################
  function valid_ymd(&$model, $data, $col )
  {
    list($k, $v) = each($data);
    if ($v === '') return TRUE;

    $tmp = explode('-', $v);
    if (count($tmp) != 3) return false;
    $yyyy = $tmp[0];
    $mm = $tmp[1];
    $dd = $tmp[2];
    return checkdate($mm, $dd, $yyyy);
  }

  #########################################################################
  /**
   *  値が他のレコードで使われていないか
   *  バリデーションルール「isUnique」はstatusカラムの値を加味しないが、
   *  valid_isUniqueWithStatusでは、statusが0(無効)のカラムを存在しないものとして扱う
   */
  #########################################################################
  function valid_isUniqueWithStatus(&$model, $data, $col )
  {
    list($k, $v) = each($data);
    if ($v === '') return TRUE;

    return !(0 < $model->find('count', array(
      'conditions' => array(
        "{$model->name}.status" => 1,
        "{$model->name}.{$k}" => $v,
        "{$model->name}.id <>" => $model->id,
      )
    )));
  }

  #########################################################################
  /**
   *  値が"他の論理的に削除されていないレコード"で使われていないか
   */
  #########################################################################
  function valid_isUniqueLogically(&$model, $data, $col )
  {
    list($k, $v) = each($data);
    if ($v === '') return TRUE;

    return !(0 < $model->find('count', array(
      'conditions' => array(
        "{$model->name}.{$k}" => $v,
        "{$model->name}.is_deleted" => 0,
        "{$model->name}.id <>" => $model->id,
      )
    )));
  }

  #########################################################################
  /**
   *  値が"論理的に存在するレコード"に含まれているか
   */
  #########################################################################
  function valid_isExistLogically(&$model, $data, $modelName = NULL, $col = NULL)
  {
    list($k, $v) = each($data);
    if (empty($v)) return TRUE;

    if (is_array($modelName)) {
      $modelName = $model->name;
      $modelToUse = $model;
    } else {
      $modelToUse = ClassRegistry::init($modelName);
      $k = $col;
    }

    $r = (0 < $modelToUse->find('count', array(
      'conditions' => array(
        "{$modelName}.{$k}" => $v,
        "{$modelName}.is_deleted" => 0,
      )
    )));

    return $r;
  }

  #########################################################################
  /**
   *  値が"論理的に存在するレコード"に含まれており、また追加の条件もクリアしているか
   */
  #########################################################################
  function valid_hasOwnershipLogically(&$model, $data, $cols = NULL)
  {
    list($k, $v) = each($data);
    if (empty($v)) return TRUE;

    $cond = array(
      "{$model->name}.{$k}" => $v,
      "{$model->name}.is_deleted" => 0,
    );

    foreach ($cols as $col) {
      $cond["{$model->name}.{$col}"] = $model->data[$model->name][$col];
    }

    $r = (0 < $model->find('count', array(
      'conditions' => $cond,
    )));

    return $r;
  }

  #########################################################################
  /**
   *  値が物理的に存在しており、また追加の条件もクリアしているか
   */
  #########################################################################
  function valid_hasOwnership(&$model, $data, $cols = NULL)
  {
    list($k, $v) = each($data);
    if (empty($v)) return TRUE;

    $cond = array(
      "{$model->name}.{$k}" => $v,
    );

    foreach ($cols as $col) {
      $cond["{$model->name}.{$col}"] = $model->data[$model->name][$col];
    }

    $r = (0 < $model->find('count', array(
      'conditions' => $cond,
    )));

    return $r;
  }

  #########################################################################
  /**
   *  同一の値が条件付きで物理的に存在していないか
   */
  #########################################################################
  function valid_isUniqueWithParams(&$model, $data, $cols = NULL)
  {
    list($k, $v) = each($data);
    if (empty($v)) return TRUE;

    $cond = array("{$model->name}.{$k}" => $v,);

    foreach ($cols as $col)
    $cond["{$model->name}.{$col}"] = $model->data[$model->name][$col];

    return (0 === $model->find('count', array(
      'conditions' => $cond,
    )));
  }

  #########################################################################
  /**
   *  値が存在しているか
   */
  #########################################################################
  function valid_isExist(&$model, $data, $modelName = NULL, $col = NULL)
  {
    list($k, $v) = each($data);
    if (empty($v)) return TRUE;

    if (is_array($modelName)) {
      $modelName = $model->name;
      $modelToUse = $model;
    } else {
      $modelToUse = ClassRegistry::init($modelName);
      $k = $col;
    }

    $r = (0 < $modelToUse->find('count', array(
      'conditions' => array(
        "{$modelName}.{$k}" => $v,
      )
    )));

    return $r;
  }

  function valid_inClassArrayKeys(&$model, $data, $arrayName)
  {
    list($k, $v) = each($data);
    if ($v === '') return TRUE;

    return (in_array($v, array_keys($model::${$arrayName})));
  }

  #########################################################################
  /**
   *  半角数字しか含まれていないか
   */
  #########################################################################
  function valid_int(&$model, $data, $col )
  {
    list($k, $v) = each($data);
    if ($v === '') return TRUE;

    return (preg_match('/^[0-9]*$/', $v));
  }

  #########################################################################
  /**
   *  整数かどうか
   */
  #########################################################################
  function valid_positive_number(&$model, $data, $col )
  {
    list($k, $v) = each($data);
    if (($v === '') || $v == '0') return TRUE;

    return (preg_match('/^[1-9][0-9]*$/', $v));
  }

  #########################################################################
  /**
   *  アップロードが成功したか
   */
  #########################################################################
  function valid_upload(&$model, $data)
  {
    list($k, $v) = each($data);
    if ($v === '') return TRUE;

    if ((isset($v['error']) && $v['error'] == 0)
      || (!empty($v['tmp_name']) && $v['tmp_name'] != 'none')
    ) {
      return is_uploaded_file($v['tmp_name']);
    } else {
      return false;
    }
  }

  #########################################################################
  /**
   *  x個の要素(空要素は除く)を持つ配列かどうか
   */
  #########################################################################
  public function valid_array_having_values(&$model, $data, $col )
  {
    list($k, $v) = each($data);
    if ($v === '') return TRUE;

    if (empty($v) || !is_array($v)) return false;
    if ($col > count(array_diff($v, array('')))) return false;
    return true;
  }

  #########################################################################
  /**
   *  日付が範囲内から確認
   */
  #########################################################################
  public function valid_date_range(&$model, $data, $col )
  {
    list($k, $v) = each($data);
    if ($v === '') return TRUE;

    if (($v < $col[0]) || ($v > $col[1])) return false;

    return true;
  }

  #########################################################################
  /**
   *  文字数が一致するか確認
   */
  #########################################################################
  public function valid_justLen(&$model, $data, $len)
  {
    list($k, $v) = each($data);

    if (mb_strlen($v) == $len){
      return TRUE;
    } else {
      return FALSE;
    }
  }

  #########################################################################
  /**
   *  今日以降の日付か確認
   * @param int $move 現在時刻から$move時間分移動する。マイナス指定も可能。単位は時間。
   */
  #########################################################################
  public function valid_dateLaterToday(&$model, $data, $move = 0)
  {
    list($k, $v) = each($data);
    if($v === '') return TRUE;

    $timeTarget = (int)date('U', strtotime($v));
    $timeNow = (int)date('U') + ($move * 3600);

    return ($timeTarget > $timeNow);
  }

  public function valid_available(&$model, $data)
  {
    list($k, $v) = each($data);
    if ($v === '') return TRUE;

    foreach (Configure::read('Config.unavailable') as $unavailable) {
      if ($unavailable == $v) {
        return FALSE;
      }
    }

    return TRUE;
  }
}

