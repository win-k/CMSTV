<?php
App::uses('AppModel', 'Model');

class Comment extends AppModel
{
  const OPTION_BIND_ENTRY = 'OPTION_BIND_ENTRY';
  const OPTION_BIND_ENTRY_NO_RESET = 'OPTION_BIND_ENTRY_NO_RESET';
  public $name = 'Comment';
  public $valid = array(
    'add' => array(
      'entry_id'  => 'required | isExist[Entry,id]',
      'name'      => 'required | maxLen[50]',
      'body'      => 'required | maxLen[4000]',
    ),
    'update' => array(
      'id' => 'required | isExist'
    ),
  );
  public $virtualFields = array(
    'page_path' => 'SELECT Page.path FROM pages as Page WHERE Page.id = (SELECT Entry.page_id FROM entries as Entry WHERE Entry.id = Comment.entry_id)',
  );
  public $columnLabels = array();
  public static $APPROVED = array();

  public function __construct($id = false, $table = null, $ds = null)
  {
    parent::__construct($id, $table, $ds);

    $this->columnLabels = array(
      'name' => __('お名前'),
      'body' => __('コメント'),
    );

    self::$APPROVED = array(
      0 => __('未承認'),
      1 => __('承認済み'),
    );
  }

  public function afterFind($results, $primary = false)
  {
    foreach ($results as &$result) {
      if (empty($result[$this->name])) continue;

      if (!empty($result[$this->name]['page_path']) && !empty($result[$this->name]['entry_id'])) {
        $result[$this->name]['entry_path'] = sprintf('%s?e=%s', $result[$this->name]['page_path'], $result[$this->name]['entry_id']);
      }
    }

    return $results;
  }

  public function submit($data, &$page)
  {
    try {
      $this->begin();

      if (empty($data['name'])) $data['name'] = 'Guest';
      if (empty($data['ip'])) $data['ip'] = $_SERVER["REMOTE_ADDR"];
      if (empty($data['host'])) $data['host'] = gethostbyaddr($data['ip']);

      $this->loadModel('Entry');
      $options = $this->Entry->getOptions(array(Entry::OPTION_BIND_PAGE), array(
        CONDITIONS => array(
          'Entry.id' => $data['entry_id'],
        ),
        FIELDS => array(
          'Page.id', 'Page.data', 'Page.package',
          'Entry.id',
        ),
      ));
      $page = $this->Entry->find('first', $options);
      if (empty($page))
        throw new Exception(__('ページが見つかりませんでした'));
      if ($page['Page']['data']['can_comment'] == 0)
        throw new Exception(__('このエントリはコメントを受け付けていません'));

      $data['approved'] = 1;
      if ($page['Page']['data']['can_comment'] == 1) {
        $data['approved'] = 0;
      }

      $r = $this->add($data);
      if ($r !== TRUE) throw $r;

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

    if (in_array(self::OPTION_BIND_ENTRY, $types)) {
      $this->bindModel(array(
        'belongsTo' => array('Entry'),
      ));
    }

    if (in_array(self::OPTION_BIND_ENTRY_NO_RESET, $types)) {
      $this->bindModel(array(
        'belongsTo' => array('Entry'),
      ), FALSE);
    }

    return $options;
  }

}




