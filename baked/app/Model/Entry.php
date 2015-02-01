<?php
App::uses('AppModel', 'Model');

class Entry extends AppModel
{
  const OPTION_BIND_PAGE = 'OPTION_BIND_PAGE';
  const OPTION_BIND_PAGE_NO_RESET = 'OPTION_BIND_PAGE_NO_RESET';
  const OPTION_BIND_STAFF_NO_RESET = 'OPTION_BIND_STAFF_NO_RESET';
  public $name = 'Entry';
  public $valid = array(
    'add' => array(
      'page_id'   => 'required | isExist[Page,id]',
      'staff_id'  => 'required | isExist[Staff,id]',
      'title'     => 'required | maxLen[100]',
      'body1'     => 'required',
      #'body2'     => '',
      'published' => 'required | datetime',
    ),
    'update' => array(
      'id' => 'required | isExist'
    ),
  );
  public $virtualFields = array(
    'comments_count' => 'SELECT COUNT(Comment.id) FROM comments as Comment WHERE Comment.entry_id = Entry.id',
    'approved_comments_count' => 'SELECT COUNT(Comment.id) FROM comments as Comment WHERE Comment.entry_id = Entry.id AND Comment.approved = 1',
    'unapproved_comments_count' => 'SELECT COUNT(Comment.id) FROM comments as Comment WHERE Comment.entry_id = Entry.id AND Comment.approved = 0',
  );
  #public $columnLabels = array();

  public function __construct($id = false, $table = null, $ds = null)
  {
    return parent::__construct($id, $table, $ds);
  }

  public function afterFind($results, $primary = false)
  {
    foreach ($results as &$result) {
      if (empty($result[$this->name])) continue;

      if (!empty($result['Page']['path']) && !empty($result[$this->name]['id'])) {
        $result[$this->name]['path'] = sprintf('%s?e=%s', $result['Page']['path'], $result[$this->name]['id']);
      }
    }

    return $results;
  }

  public function delete($id = null, $cascade = true)
  {
    try {
      $this->begin();

      if ($cascade) {
        $this->loadModel('Comment');
        $commentIds = $this->Comment->find('list', array(
          CONDITIONS => array('Comment.entry_id' => $id),
          FIELDS => array('Comment.id'),
          'limit' => FALSE,
        ));
        if ($commentIds) {
          foreach ($commentIds as $commentId) {
            $r = $this->Comment->delete($commentId);
            if ($r !== TRUE) throw new Exception(__('コメントの削除に失敗しました'));
          }
        }
      }

      $r = parent::delete($id, $cascade);
      if ($r !== TRUE) throw new Exception(__('Entryレコードの削除に失敗しました。'));

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

    if (in_array(self::OPTION_BIND_PAGE, $types)) {
      $this->bindModel(array(
        'belongsTo' => array('Page'),
      ));
    }

    if (in_array(self::OPTION_BIND_PAGE_NO_RESET, $types)) {
      $this->bindModel(array(
        'belongsTo' => array('Page'),
      ), TRUE);
    }

    if (in_array(self::OPTION_BIND_STAFF_NO_RESET, $types)) {
      $this->bindModel(array(
        'belongsTo' => array('Staff'),
      ), TRUE);
    }

    return $options;
  }
}




