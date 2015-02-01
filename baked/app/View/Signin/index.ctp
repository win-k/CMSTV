<a href="<?php echo URL ?>" style="font-size: 9pt;"><i class="fa fa-arrow-circle-o-left"></i> <?php echo __('%sへ戻る', BK_SITE_NAME) ?></a>
<div class="spacer1"></div>

<?php
echo $this->Form->create('Staff', array(
  'url' => '/system/signin',
  'class' => 'form-01',
));
echo $this->Baked->hiddenToken();
?>
<?php
echo $this->Form->input('email', array(
  'label' => __('メールアドレス'),
));
echo $this->Form->input('password', array(
  'label' => __('パスワード'),
));
?>

<div class="spacer1"></div>

<button type="submit" class="button button-primary button-pill button-small"><?php echo __('サインイン') ?></button>

<?php
echo $this->Form->end();
?>



