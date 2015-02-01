<?php
App::uses('Model', 'Model');

class BaseModel extends Model
{
  public $actsAs = array('BasicValidation');
  public $addLabelInValidate = TRUE;
  private $originalFindType = false;
  static $transactionCount = 0; // トランザクション実行回数
  const VALIDATION_MODE_ONLY = 10;
  const VALIDATION_MODE_REQUIRED = 20;
  const VALIDATION_MODE_SKIP = 30;

  protected function begin()
  {
    self::$transactionCount++;
    if (self::$transactionCount != 1) return ;

    if (!$this->useTable) return;

    $db = ConnectionManager::getDataSource($this->useDbConfig);
    $db->begin($this);
  }

  protected function commit()
  {
    self::$transactionCount--;
    if (self::$transactionCount != 0) return ;

    if (!$this->useTable) return;

    $db = ConnectionManager::getDataSource($this->useDbConfig);
    $db->commit($this);
  }

  protected function rollback()
  {
    self::$transactionCount--;
    if (self::$transactionCount != 0) return ;

    if (!$this->useTable) return;

    $db = ConnectionManager::getDataSource($this->useDbConfig);
    $db->rollback($this);
  }

/**
 * 文字列からハッシュ値を取得
 *
 * @param string
 * @return string A hash of the string.
 */
  public function hash($string)
  {
    return hash('sha256', $string);
  }

/**
 * array(ModelName => array(id,column..))からarray(id,column..)に変換
 *
 * @param array $data
 * @return array array(id,column)
 */
    public function getDeepArray(&$data)
    {
        return isset($data[$this->name]) ? $data[$this->name] : $data ;
    }

/**
 * 最後の追加/更新したレコード配列を取得
 *
 * @return mixed array/FALSE
 */
    public function getLastInsertData()
    {
        return $this->findById($this->id);
    }

/**
 * レコードの追加/更新
 *
 * @param array $data
 * @param bool $update
 * @param sting $useValid
 * @param bool $onlyValidate
 * @return mixed OK:true / NG:Exception
 */
  public function add($data, $update = NULL, $useValid = NULL, $validateMode = FALSE)
  {
    try {
      $this->begin();
      if ($this->useTable !== FALSE) $this->create();

      if ($validateMode === FALSE) $validateMode = self::VALIDATION_MODE_REQUIRED;

      if (!isset($data[$this->name])) {
        $tmp = $data;
        $data = array($this->name => $tmp);
      }

      $updateFields = $this->updateFields;

      $this->set($data);

      if (($update !== false)
        && (!empty($this->data[$this->name]['id']) || ($update === true))
      ) {
        $this->id = (isset($this->data[$this->name]['id'])) ? $this->data[$this->name]['id'] : NULL ;
        $this->useValid = 'update';
        $updateFields = array_keys($data[$this->name]);
      } else {
        $this->id = null;
        unset($this->data[$this->name]['id']);
        $this->useValid = 'add';
      }

      if ($useValid) $this->useValid = $useValid;

      if (in_array($validateMode, array(self::VALIDATION_MODE_ONLY, self::VALIDATION_MODE_REQUIRED))) {
        #v($this->useTable);
        $r = $this->validates(array('fieldList' => $updateFields));

        if (!$r) {
          list($key, $val) = each($this->validationErrors);
          throw new Exception($val[0]);
        }
      }

      if (in_array($validateMode, array(self::VALIDATION_MODE_REQUIRED, self::VALIDATION_MODE_SKIP))) {
        if (!$this->save($this->data, false, $updateFields)) {
          throw new Exception('DBへの保存に失敗しました');
        }
      }

      $this->commit();
      return true;
    } catch (Exception $e) {
      #$this->log(debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS), LOG_INFO);
      $this->rollback();
      return $e;
    }
  }

/**
 * バリデーションルールから入力必須ルールを削除
 *
 * @param string $useValid
 */
    public function unableRequiredRule($useValid, $exceptions = array(), $delete = false)
    {
        if($this->valid == NULL) return;
        foreach ($this->valid[$useValid] as $columnName => &$rule) {
            if (in_array($columnName, $exceptions)) continue;

            if (!$delete) {
                $rule = preg_replace('/required/', 'notEmpty', $rule);
            } else {
                $rule = preg_replace('/^required$/', '', $rule);
                $rule = preg_replace('/required \| /', '', $rule);
            }
            if ($rule == '') { unset($this->valid[$useValid][$columnName]); }
        }
    }

/**
 * BasicValidationBehaivorによるバリデーションルールの設定
 */
    public function loadValidate() {
        $this->validate = array();

        if ($this->useValid == 'update') {
            if (isset($this->valid['add'])){
                $this->valid['update'] += $this->valid['add'];;
            }
            $this->unableRequiredRule('update', array('id'));
        }

        if (isset($this->useValid) && !is_null($this->useValid) && isset($this->valid["{$this->useValid}"])) {
            foreach ($this->valid["{$this->useValid}"] as &$rule) {
                $rule = preg_replace('/super_/', '', $rule);

                if (preg_match('/mustIn\[([^,]*),([^\]]*)\]/', $rule, $matchs)) {
                    $col = $matchs[1];
                    $val = $matchs[2];
                    if (!isset($this->data[$this->name][$col]) || ($this->data[$this->name][$col] != $val)) {
                        $rule = str_replace($matchs[0], '', $rule);
                    } else {
                        $rule = str_replace($matchs[0], 'required', $rule);
                    }
                }
            }

            $this->setValidate($this->valid["{$this->useValid}"]);
        }

        if ($this->addLabelInValidate && isset($this->columnLabels)) {
            foreach ($this->validate as $columnName => &$column) {
                foreach ($column as &$settings) {
                    if (isset($this->columnLabels[$columnName])) {
                        $label = $this->columnLabels[$columnName];
                    } else {
                        $label = $columnName;
                    }
                    $settings['message'] = "{$label}: ".$settings['message'];
                }
            }
        }
    }

    protected function loadModel($modelName)
    {
      if (!isset($this->{$modelName})) $this->{$modelName} = ClassRegistry::init($modelName);
    }

/**
 * そのテーブルで一意となる任意の桁のコードを生成
 *
 * @param int $digit 生成するコードの桁数
 * @param int $column コードを保持するテーブルのカラム名
 * @return string Generated code.
 */
    protected function generateUniqueCode($digit, $column = 'code')
    {
        $code;
        while (TRUE) {
            $code = getRandomString($digit);
            if (0 === $this->find('count', array(
                'conditions' => array(
                    "{$this->name}.{$column}" => $code,
                ),
            ))) break;
        }
        return $code;
    }

/**
 * Model::findのためのキーワード検索用conditionsを生成
 *
 * @param array $keywords 検索キーワードの配列。複数指定でAND検索。
 * @param array $columns 検索対象のカラム名の配列。
 * @param string $mode
 * @return array 生成したconditions配列。
 */
  public function generateSearchConditions($keywords, $columns)
  {
    if (is_string($keywords)) {
      $keywords = str_replace('　', ' ', $keywords);
      $keywords = explode(' ', $keywords);
      $keywords = array_unique($keywords);
      $keywords = array_filter($keywords);
    }

    $conditions = array();
    foreach ($keywords as $keyword) {
      $condition = array('OR' => array());
      if (is_string($keyword)) $keyword = array($keyword);
      foreach ($columns as $column) {
        if (!preg_match('/\./', $column)) {
          $columnName = sprintf('%s.%s LIKE', $this->name, $column);
        } else {
          $columnName = sprintf('%s LIKE', $column);
        }
        foreach ($keyword as $k) {
          $condition['OR'][][$columnName] = sprintf('%%%s%%', $k);
        }
      }
      $conditions[] = $condition;
    }
    return $conditions;
  }

    function paginateCount2($conditions = null, $recursive = 0, $extra = array()) {
        $parameters = compact('conditions');
        $this->recursive = $recursive;
        $count = $this->find('count', array_merge($parameters, $extra));
        if (isset($extra['group'])) {
            $count = $this->getAffectedRows();
        }
        return $count;
    }

    public function find2($type = 'first', $query = array())
    {
        if (isset($query['limit'])) {
            if (is_array($query['limit'])) $query['limit'] = end($query['limit']);
            if ($query['limit'] === 'false') $query['limit'] = FALSE;
        } else {
            #$query['limit'] = 20;
        }

        $type = preg_replace('/[a-z0-9-_]+-/i', '', $type);

        return parent::find($type, $query);
    }

/**
 * Model::findのためのoptionsを生成
 *
 * @param array
 * @param array
 * @return array options
 */
    public function getOptions($types, $options = array())
    {
        if (is_string($types)) $types = array($types);

        // is_deleted=0を条件付与
        if (in_array('only_live', $types)) {
            $options = array_merge_recursive(array(
                'conditions' => array(
                    "{$this->name}.is_deleted" => 0,
                ),
            ), $options);
        }

        return $options;
    }

}






