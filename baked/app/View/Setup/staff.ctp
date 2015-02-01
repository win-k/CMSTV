<p>
<?php echo __('管理者の情報を入力してください。') ?>
</p>

<?php
echo $this->Form->create('Staff', array(
  'url' => '/system/setup/staff',
  'class' => 'form-01',
));
?>
<?php
echo $this->Form->input('name', array(
  'label' => __('お名前'),
));
echo $this->Form->input('email', array(
  'label' => __('メールアドレス'),
));
echo $this->Form->input('password', array(
  'label' => __('パスワード'),
));
?>

<div class="spacer1"></div>

<button type="submit" class="button button-primary button-pill button-small"><?php echo __('Save') ?></button>

<?php
echo $this->Form->end();
?>



