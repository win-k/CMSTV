<p>
<?php echo __('サイトの情報を入力してください。') ?>
</p>

<?php
echo $this->Form->create('Validator', array(
  'url' => '/system/setup/site',
  'class' => 'form-01',
));
?>
<?php
echo $this->Form->input('site_name', array(
  'label' => __('サイト名'),
));
?>

<div class="spacer1"></div>

<button type="submit" class="button button-primary button-pill button-small"><?php echo __('Save') ?></button>

<?php
echo $this->Form->end();
?>



