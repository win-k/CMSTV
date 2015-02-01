<?php
App::uses('AppModel', 'Model');

class Page extends AppModel
{
  public $name = 'Page';
  public $valid = array(
    'add' => array(
      'title'          => 'required | maxLen[255]',
      'name'           => 'required | maxLen[255] | alphaNumeric | available',
      'parent_page_id' => 'isExist[Page,id]',
      'hidden'         => 'valid_no_hidden',
    ),
    'data' => array(
      'entries_per_page' => 'notEmpty | numeric | range[0,101]',
      'can_comment'      => 'inClassArrayKeys[CAN_COMMENT]',
      'sent_text'        => 'notEmpty | maxLen[1000]',
    ),
    'update' => array(
      'id' => 'required | valid_isExist'
    ),
  );
  public $virtualFields = array(
    'entries_count' => 'SELECT COUNT(Entry.id) FROM entries as Entry WHERE Entry.page_id = Page.id',
    'comments_count' => 'SELECT COUNT(Comment.id) FROM comments as Comment WHERE Comment.entry_id IN (SELECT Entry.id FROM entries as Entry WHERE Entry.page_id = Page.id)',
  );
  public $columnLabels = array(
    'title' => 'タイトル',
    'name' => 'ページ名',
  );
  public static $CAN_COMMENT = array();

  public function __construct($id = false, $table = null, $ds = null)
  {
    $this->___columnLabels = array(
      'title'  => __('タイトル'),
      'name'   => __('ページ名 (英数字)'),
      'hidden' => __('非表示'),
    );

    self::$CAN_COMMENT = array(
      0 => __('不可'),
      1 => __('承認制'),
      2 => __('許可'),
    );

    return parent::__construct($id, $table, $ds);
  }

  public function afterFind($results, $primary = false)
  {
    foreach ($results as &$result) {
      if (empty($result[$this->name])) continue;

      if (isset($result[$this->name]['data'])) {
        $result[$this->name]['data'] = json_decode($result[$this->name]['data'], TRUE);
      }

      if (@$result[$this->name]['package'] == 'PageBlog') {
        if (!isset($result[$this->name]['data']['entries_per_page'])) {
          $result[$this->name]['data']['entries_per_page'] = 10;
        }
        if (!isset($result[$this->name]['data']['can_comment'])) {
          $result[$this->name]['data']['can_comment'] = 2;
        }
        if (!isset($result[$this->name]['data']['sent_text'])) {
          $result[$this->name]['data']['sent_text'] = __('コメントを送信しました。<br>管理者の承認後にコメントが表示される場合があります。');
        }
      }
    }

    return $results;
  }

  public function updatePathAll()
  {
    try {
      $this->begin();

      $pages = $this->find('all', array(
        FIELDS => array(
          "{$this->name}.id", "{$this->name}.name", "{$this->name}.parent_page_id",
        ),
        ORDER => array(
          "{$this->name}.order" => 'asc',
        )
      ));

      $pagePointers = array();

      foreach ($pages as &$page) {
        if ($page['Page']['parent_page_id'] == 0) {
          $page['Page']['url'] = URL.$page['Page']['name'];
          $page['Page']['depth'] = 0;
        } else {
          $p = &$pagePointers[$page['Page']['parent_page_id']];
          if (empty($p)) continue;
          $page['Page']['url'] = $p['Page']['url'].'/'.$page['Page']['name'];
          $page['Page']['depth'] = $p['Page']['depth'] + 1;
        }
        $pagePointers[$page['Page']['id']] = $page;
      }

      foreach ($pagePointers as $pagePointer) {
        $data = array(
          'id' => $pagePointer['Page']['id'],
          'path' => $pagePointer['Page']['url'],
          'depth' => $pagePointer['Page']['depth'],
        );
        $r = $this->add($data, TRUE, NULL, self::VALIDATION_MODE_SKIP);
        if ($r !== TRUE) throw $r;
      }

      $this->commit();
      return TRUE;
    } catch (Exception $e) {
      $this->rollback();
      return $e;
    }
  }

/**
 * IDとdata配列を渡して更新
 *
 * @param int $id
 * @param array $data
 * @return mixed true on success. Exception on failed.
 */
  public function updateData($id, $data, $useValid = false)
  {
    try {
      $this->begin();

      $page = $this->find('first', array(
        CONDITIONS => array('Page.id' => $id),
        FIELDS => array('Page.id', 'Page.data', 'Page.package'),
      ));
      if (empty($page)) throw new Exception(__('ページが見つかりませんでした'));

      if ($useValid) {
        $r = $this->add($data, NULL, $useValid, self::VALIDATION_MODE_ONLY);
        if ($r !== TRUE) throw $r;
      }

      $data += $page['Page']['data'];

      $modelData = array(
        'id'   => $id,
        'data' => json_encode($data),
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

  public function loadValidate()
  {
    parent::loadValidate();

    if (isset($this->validate['hidden']['valid_no_hidden'])) {
      $this->validate['hidden']['valid_no_hidden']['message'] = __('トップページをセットできませんでした。');
    }
    if (isset($this->validate['name']['valid_available'])) {
      $this->validate['name']['valid_available']['message'] = sprintf('"%s"という文字列は使用できません', $this->data[$this->name]['name']);
    }
  }

  public function insertPage($title = NULL, $name = NULL, $package = 'PagePlain', $beforePageId = 0)
  {
    try {
      $this->begin();

      if (empty($title)) {
        $title = __('新規ページ');
        if ($package == 'PageBlog') $title = __('新規ブログ');
      }
      if (empty($name)) $name = $this->getNewName();

      $parentPageId = 0;
      $depth = 0;

      $newPageIds = array();
      $pageIds = $this->find('list', array(
        FIELDS => array('Page.id'),
        ORDER => array('Page.order' => 'asc'),
      ));

      if (!empty($beforePageId)) {
        $beforePage = $this->find('first', array(
          CONDITIONS => array('Page.id' => $beforePageId),
          FIELDS => array('Page.depth', 'Page.parent_page_id'),
        ));
        $parentPageId = $beforePage['Page']['parent_page_id'];
        $depth = $beforePage['Page']['depth'];
      }

      $data = array(
        'title'          => $title,
        'name'           => $name,
        'package'        => $package,
        'parent_page_id' => $parentPageId,
        'depth'          => $depth,
      );
      $r = $this->add($data, FALSE);
      if ($r !== TRUE) throw $r;

      $inserted = FALSE;
      foreach ($pageIds as $pageId) {
        $newPageIds[] = $pageId;
        if ($pageId == $beforePageId) {
          $newPageIds[] = $this->id;
          $inserted = TRUE;
        }
      }
      if (!$inserted) $newPageIds[] = $this->id;

      $this->saveOrder($newPageIds);
      if ($r !== TRUE) throw $r;

      $this->commit();
      return TRUE;
    } catch (Exception $e) {
      $this->rollback();
      return $e;
    }
  }

  public function saveOrder($pageIds)
  {
    try {
      $this->begin();

      $order = 0;
      foreach ($pageIds as $pageId) {
        $data = array(
          'id' => $pageId,
          'order' => $order,
        );
        $r = $this->add($data, TRUE);
        if ($r !== TRUE) throw $r;
        $order++;
      }

      $r = $this->updatePathAll();
      if ($r !== TRUE) throw $r;

      $this->commit();
      return TRUE;
    } catch (Exception $e) {
      $this->rollback();
      return $e;
    }
  }

  public function getNewName()
  {
    $i = 1;
    $name = NULL;
    while ($i <= 100) {
      $name = sprintf('page%d', $i);
      $current = $this->find('first', array(
        CONDITIONS => array("{$this->name}.name" => $name),
      ));
      if (empty($current)) break;
      $i++;
    }
    return $name;
  }

/**
 * @param array $pages Ordered pages.
 * @return mixed true on success. Exception on failed.
 */
  public function update($pages)
  {
    try {
      $this->begin();

      $parentPageIds = array(0);
      $beforePage = NULL;
      $hasIndex = FALSE;

      foreach ($pages as $page) {
        $page = arrayWithKeys($page, array('id', 'name', 'title', 'depth', 'order', 'hidden'));

        if ($page['depth'] == 0 && $page['name'] == 'index') {
          $hasIndex = TRUE;
        }

        if (!empty($beforePage)) {
          if ($beforePage['depth'] < $page['depth']) {
            $parentPageIds[] = $beforePage['id'];
          }
          elseif ($beforePage['depth'] > $page['depth']) {
            $diff = $beforePage['depth']-$page['depth'];
            for ($i=0; $i < $diff; $i++) array_pop($parentPageIds);
          }
        }
        $page['parent_page_id'] = $parentPageIds[count($parentPageIds)-1];
        $r = $this->add($page, TRUE);
        if ($r !== TRUE) {
          throw $r;
        }

        $beforePage = $page;
      }

      if (!$hasIndex) throw new Exception(__('トップページが存在しません。'));

      $subQuery = "EXISTS (SELECT TmpPage.id FROM pages as TmpPage WHERE TmpPage.id <> Page.id AND TmpPage.name = Page.name AND TmpPage.parent_page_id = Page.parent_page_id)";
      $page = $this->find('first', array(
        CONDITIONS => array($subQuery),
        FIELDS => array('Page.id', 'Page.name'),
      ));
      if (!empty($page)) throw new Exception(__('同じ階層に同名のページが2つ以上存在しています。', $page['Page']['name']));

      $r = $this->updatePathAll();
      if ($r !== TRUE) throw $r;

      $this->commit();
      return TRUE;
    } catch (Exception $e) {
      $this->rollback();
      return $e;
    }
  }

/**
 * Get menu list.
 *
 * @param array $path
 * @param pointer &$currentMenu
 * @param pointer &$pageId
 * @return array
 */
  public function menu($path, &$currentMenuP, &$pageId)
  {
    $cond = array();
    #if (!EDITTING) $cond["{$this->name}.hidden"] = 0;
    $pages = $this->find('all', array(
      CONDITIONS => $cond,
      FIELDS => array(
        "{$this->name}.id", "{$this->name}.name", "{$this->name}.package", "{$this->name}.title", "{$this->name}.parent_page_id", "{$this->name}.path", "{$this->name}.data", "{$this->name}.depth", "{$this->name}.hidden",
      ),
      ORDER => array(
        "{$this->name}.order" => 'asc',
      )
    ));

    $menuList = array();
    $pagePointers = array();

    foreach ($pages as &$page) {
      $pointer;
      if ($page['Page']['parent_page_id'] == 0) {
        $pointer = &$menuList;
      } else {
        $p = &$pagePointers[$page['Page']['parent_page_id']];
        if (empty($p)) continue;
        $pointer = &$p['sub'];
      }
      $page['sub'] = array();
      $depth = $page['Page']['depth'];
      $page['current'] = (count($path) > $depth && $path[$depth] == $page['Page']['name']);
      $page['here'] = (count($path)-1 == $depth && $path[$depth] == $page['Page']['name']);

      $pagePointers[$page['Page']['id']] = $page;

      if (EDITTING || $page['Page']['hidden'] == 0) {
        $pointer[] = &$pagePointers[$page['Page']['id']];
      }

      if ($page['here']) {
        $pageId = $page['Page']['id'];
      }
    }

    $currentMenuP = @$pagePointers[$pageId];

    return $menuList;
  }

  public function delete($id = null, $cascade = true)
  {
    try {
      $this->begin();

      $current = $this->find('first', array(
        CONDITIONS => array('Page.id' => $id),
        FIELDS => array('Page.parent_page_id', 'Page.name', 'Page.depth', 'Page.package'),
      ));
      if ($current['Page']['name'] == 'index' && $current['Page']['depth'] == 0) {
        throw new Exception(__('トップページは削除できません。'));
      }

      $childPageIds = $this->find('list', array(
        CONDITIONS => array('Page.parent_page_id' => $id,),
        FIELDS => array('Page.id'),
        'limit' => FALSE,
      ));
      foreach ($childPageIds as $childPageId) {
        $data = array(
          'id' => $childPageId,
          'parent_page_id' => $current['Page']['parent_page_id'],
        );
        $r = $this->add($data, TRUE);
        if ($r !== TRUE) throw new Exception(__('子ページのアップデートに失敗しました (%s)', $r->getMessage()));
      }

      $this->loadModel('Block');
      $blockIds = $this->Block->find('list', array(
        FIELDS => array('Block.id'),
        CONDITIONS => array('Block.page_id' => $id),
        'limit' => FALSE,
      ));
      foreach ($blockIds as $blockId) {
        $r = $this->Block->delete($blockId);
        if ($r !== TRUE) throw new Exception(__('ブロックの削除に失敗しました。 #%d (%s)', $blockId, $r->getMessage()));
      }

      $r = TRUE;
      switch ($current['Page']['package']) {
        case 'PagePlain': $r = $this->__deletePagePlain($id); break;
        case 'PageBlog':  $r = $this->__deletePageBlog($id);  break;
      }
      if ($r !== TRUE) throw $r;

      $r = parent::delete($id, $cascade);
      if ($r !== TRUE) throw new Exception(__('Pageレコードの削除に失敗しました。'));

      $r = $this->updatePathAll();
      if ($r !== TRUE) throw $r;

      $this->commit();
      return TRUE;
    } catch (Exception $e) {
      $this->rollback();
      return $e;
    }
  }

  private function __deletePagePlain($pageId)
  {
    return TRUE;
  }

  private function __deletePageBlog($pageId)
  {
    try {
      $this->begin();

      $this->loadModel('Entry');
      $entryIds = $this->Entry->find('list', array(
        CONDITIONS => array(
          'Entry.page_id' => $pageId,
        ),
        FIELDS => array('Entry.id'),
      ));
      foreach ($entryIds as $entryId) {
        $r = $this->Entry->delete($entryId);
        if ($r !== TRUE) throw $r;
      }

      $this->commit();
      return TRUE;
    } catch (Exception $e) {
      $this->rollback();
      return $e;
    }
  }

  public function valid_no_hidden($data)
  {
    list($k, $v) = each($data);
    if ($v === '') return TRUE;
    if (!isset($this->data[$this->name]['name'])) return;
    if (!isset($this->data[$this->name]['parent_page_id'])) return;

    if ($v == 0) return TRUE;
    if ($this->data[$this->name]['name'] !== 'index') return TRUE;
    if ($this->data[$this->name]['parent_page_id'] !== 0) return TRUE;

    return FALSE;
  }

}












