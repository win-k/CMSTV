<?php
$id = "bk-block-text-{$block['Block']['id']}";
echo $this->Form->create('Block', array(
  'default' => FALSE,
  'data-block-editor-text',
));
?>
<?php
echo $this->Form->input('Block.text', array(
  'type' => 'textarea',
  'id' => $id,
  'label' => FALSE,
  'value' => $block['Block']['data']['text'],
  'default' => FALSE,
  'class' => 'ckeditor-textarea',
));
?>

<div class="spacer1"></div>

<button type="submit" class="button button-primary button-pill button-small"><?php echo __('保存') ?></button>

<?php
echo $this->Form->end();
?>

<script>
$(function(){
  $('#<?php echo $id ?>').bkCkeditor();
});
</script>
