<?php
App::uses('AppModel', 'Model');

class Staff extends AppModel
{
  public $name = 'Staff';
  public $valid = array(
    'add' => array(
      'name'     => 'required | maxLen[50]',
      'email'    => 'required | email | maxLen[100] | isUnique',
      'password' => 'required | minLen[6] | maxLen[32]',
    ),
    'first_add' => array(
      'name'     => 'required | maxLen[50]',
      'email'    => 'required | email | maxLen[100]',
      'password' => 'required | minLen[6] | maxLen[32]',
    ),
    'update' => array(
      'id' => 'required | isExist'
    ),
  );

  public function addDataHavingPassword($data, $update = NULL)
  {
    try {
      $this->begin();

      $r = $this->add($data, $update, NULL, self::VALIDATION_MODE_ONLY);
      if ($r !== TRUE) throw $r;

      if (isset($data['password'])) {
        $data['password'] = $this->hash($data['password']);
      }

      $r = $this->add($data, $update, NULL, self::VALIDATION_MODE_SKIP);
      if ($r !== TRUE) throw $r;

      $this->commit();
      return TRUE;
    } catch(Exception $e) {
      $this->rollback();
      return $e;
    }
  }

  public function editmode($switch = TRUE)
  {
    $_SESSION['Staff']['Editmode'] = $switch;
  }

  public function auth($params)
  {
    if (empty($params['email'])) throw new Exception(__('メールアドレスは必須です。'));
    if (empty($params['password'])) throw new Exception(__('パスワードは必須です。'));

    $staff = $this->find('first', array(
      CONDITIONS => array(
        'Staff.email'    => $params['email'],
        'Staff.password' => $this->hash($params['password']),
      ),
      FIELDS => array(
        'Staff.id',
      ),
    ));
    if (empty($staff)) throw new Exception(__('メールアドレス又はパスワードが間違っています。'));

    $this->signIn($staff['Staff']['id']);

    return TRUE;
  }

  public function signIn($staffId)
  {
    $staff = $this->find('first', array(
      CONDITIONS => array(
        'Staff.id' => $staffId,
      ),
      FIELDS => array(
        'Staff.id', 'Staff.name', 'Staff.email',
      ),
    ));
    $staff['Staff']['editmode'] = FALSE;
    $_SESSION['Staff'] = $staff['Staff'];
  }

  public function signOut()
  {
    $_SESSION['Staff'] = FALSE;
  }
}

