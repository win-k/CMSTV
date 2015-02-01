<?php
App::uses('BlockAppModel', 'Model');

class BlockHeading extends BlockAppModel
{
  public $name = 'BlockHeading';
  public $useTable = FALSE;
  public $valid = array(
    'add' => array(
      'h'    => 'required | inClassArrayKeys[H]',
      'text' => 'required | maxLen[50]',
    ),
    'update' => array(
      'id' => 'required | isExist'
    ),
  );
  public $columnLabels = array();
  public static $H;

  public function __construct($id = false, $table = null, $ds = null)
  {
    parent::__construct($id, $table, $ds);
    self::$H = array(
      1 => 'Large',
      2 => 'Medium',
      3 => 'Small',
    );
    $this->columnLabels = array(
      'h'    => __('サイズ'),
      'text' => __('テキスト'),
    );
  }

/**
 * Return initiali data
 *
 * @return mixed array on success. true to ignore. false to occur error.
 */
  public function initialData()
  {
    return array(
      'h' => 1,
      'text' => __('見出し'),
    );
  }

/**
 * Callback before delete.
 *
 * @param int $blockId
 * @boolean
 */
  public function willDelete($blockId)
  {
    return TRUE;
  }



}



