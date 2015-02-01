<p>
<?php echo __('データベースに接続するための情報を入力してください。') ?>
</p>

<?php
echo $this->Form->create('Validator', array(
  'url' => '/system/setup/db',
  'class' => 'form-01',
));
?>
<?php
echo $this->Form->input('host', array(
  'label' => __('データベースのホスト'),
));
echo $this->Form->input('user', array(
  'label' => __('ユーザー名'),
));
echo $this->Form->input('password', array(
  'label' => __('パスワード'),
));
echo $this->Form->input('name', array(
  'label' => __('データベース名'),
));
echo $this->Form->input('prefix', array(
  #'label' => __('接頭辞'),
  'type' => 'hidden',
  'value' => '',
));
?>

<div class="spacer1"></div>

<button type="submit" class="button button-primary button-pill button-small"><?php echo __('Save') ?></button>

<?php
echo $this->Form->end();
?>



