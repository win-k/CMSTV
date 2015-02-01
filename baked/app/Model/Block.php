<?php
App::uses('AppModel', 'Model');

class Block extends AppModel
{
  const OPTION_ORDER_STANDARD = 'option_order_standard';
  public $name = 'Block';
  public $valid = array(
    'add' => array(
      'page_id' => 'required | isExist[Page,id]',
    ),
    'update' => array(
      'id' => 'required | isExist'
    ),
  );
  public $columnLabels = array();

  public function afterFind($results, $primary = false)
  {
    foreach ($results as &$result) {
      if (empty($result[$this->name])) continue;

      if (isset($result[$this->name]['data']))
        $result[$this->name]['data'] = json_decode($result[$this->name]['data'], TRUE);
    }

    return $results;
  }

  public function beforeSave($options = array())
  {
    if (isset($this->data['Block']['data'])) $this->data['Block']['data'] = json_encode($this->data['Block']['data']);

    return true;
  }

/**
 * Initialize and get the instance of the BlockPackage model.
 *
 * @param string $package
 * @return object instance of BlockPackage model class.
 * @throws CakeException when you try to construct an interface or abstract class.
 */
  public function initPackageModel($package)
  {
    return ClassRegistry::init(sprintf('%s.%s', $package, $package));
  }

/**
 * Add the block.
 *
 * @param id $pageId
 * @param string $package
 * @param string $sheet
 * @param int $beforeBlockId
 * @return mixed true on success. Exception on failed.
 */
  public function addByPackage($pageId, $package, $sheet, $beforeBlockId = 0, &$addedBlockId)
  {
    try {
      $this->begin();

      $data = array(
        'page_id' => $pageId,
        'package' => $package,
        'sheet' => $sheet,
      );
      $packageModel = $this->initPackageModel($package);
      $initialData = $packageModel->initialData();

      $options = $this->getOptions(array(self::OPTION_ORDER_STANDARD), array(
        CONDITIONS => array(
          'Block.page_id' => $pageId,
          'Block.sheet' => $sheet,
        ),
        FIELDS => array('Block.id'),
        'limit' => FALSE,
      ));
      $blockIds = $this->find('list', $options);
      $blockIds = array_values($blockIds);

      if ($initialData === FALSE) throw new Exception(__('初期化データの取得に失敗しました。'));
      if (is_array($initialData)) $data['data'] = $initialData;
      $r = $this->add($data, FALSE);
      if ($r !== TRUE) throw $r;
      $addedBlockId = $this->id;

      if (!empty($beforeBlockId)) {
        $newBlockIds = array();
        foreach ($blockIds as $blockId) {
          if ($beforeBlockId == $blockId) $newBlockIds[] = $addedBlockId;
          $newBlockIds[] = $blockId;
        }
        $blockIds = $newBlockIds;
      } else {
        $blockIds[] = $addedBlockId;
      }

      $r = $this->sort($blockIds);

      $this->commit();
      return TRUE;
    } catch (Exception $e) {
      $this->rollback();
      return $e;
    }
  }

/**
 * Sort blocks.
 *
 * @param array $blockIds
 * @param true
 * @throws Exception
 */
  public function sort($blockIds)
  {
    try {
      $this->begin();

      $order = 1;
      foreach ($blockIds as $blockId) {
        $data = array(
          'id' => $blockId,
          'order' => $order,
        );
        $r = $this->add($data, TRUE);
        if ($r !== TRUE) throw $r;
        $order++;
      }

      $this->commit();
      return TRUE;
    } catch (Exception $e) {
      $this->rollback();
      throw $e;
    }
  }

/**
 * IDとdata配列を渡して更新
 *
 * @param int $id
 * @param array $data
 * @return mixed true on success. Exception on failed.
 */
  public function updateData($id, $data)
  {
    try {
      $this->begin();

      $block = $this->find('first', array(
        CONDITIONS => array('Block.id' => $id),
        FIELDS => array('Block.id', 'Block.data'),
      ));
      if (empty($block)) throw new Exception(__('ブロックが見つかりませんでした'));

      $data += $block['Block']['data'];

      $modelData = array(
        'id'   => $id,
        'data' => $data,
      );
      $r = $this->add($modelData, TRUE);
      if ($r !== TRUE) throw $r;

      $this->commit();
      return TRUE;
    } catch (Exception $e) {
      $this->rollback();
      return $e;
    }
  }

/**
 * Delete block
 *
 * @param int $id
 * @return boolean $cascade
 */
  public function delete($id = NULL, $cascade = true)
  {
    try {
      $this->begin();

      $block = $this->find('first', array(
        CONDITIONS => array('Block.id' => $id),
        FIELDS => array('Block.id', 'Block.package', ),
      ));
      if (empty($block)) throw new Exception(__('ブロックが見つかりませんでした。'));

      $package = $block['Block']['package'];
      $blockModel = $this->initPackageModel($package);
      $r = $blockModel->willDelete($id);
      if ($r === FALSE) throw new Exception(__('コールバックメソッドにより、ブロックの削除を停止しました。'));

      $r = parent::delete($id, $cascade);
      if ($r === FALSE) throw new Exception(__('ブロックの削除に失敗しました。'));

      $this->commit();
      return TRUE;
    } catch (Exception $e) {
      $this->rollback();
      return $e;
    }
  }

  public function getOptions($types = array(), $options = array())
  {
    $options = parent::getOptions($types, $options);

    if (in_array(self::OPTION_ORDER_STANDARD, $types)) {
      $options = array_merge_recursive(array(
        'order' => array('Block.order' => 'asc'),
      ), $options);
    }

    return $options;
  }

}






