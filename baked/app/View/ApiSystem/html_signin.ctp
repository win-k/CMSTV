<div class="bk-general">

  <?php
  echo $this->Form->create('Staff', array(
    'default' => FALSE,
    'class' => 'bk-form-01',
    'id' => 'bk-sign-in-form',
  ));
  ?>

  <?php
  echo $this->Form->input('Staff.email', array(
    'label' => __('メールアドレス'),
  ));
  echo $this->Form->input('Staff.password', array(
    'label' => __('パスワード'),
  ));
  ?>

  <div style="height: 30px">
    <button type="submit" class="button button-primary button-pill button-small"><?php echo __('サインイン') ?></button>
  </div>

  <?php
  echo $this->Form->end();
  ?>

</div>
