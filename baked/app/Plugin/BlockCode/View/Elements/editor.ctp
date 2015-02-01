<?php
$id = "bk-block-code-{$block['Block']['id']}";
echo $this->Form->create('Block', array(
  'default' => FALSE,
  'data-block-code-form',
));
?>
<?php
echo $this->Form->input('Block.code', array(
  'type' => 'textarea',
  'id' => $id,
  'label' => FALSE,
  'value' => $block['Block']['data']['code'],
  'default' => FALSE,
));
?>

<div class="spacer1"></div>

<button type="submit" class="button button-primary button-pill button-small"><?php echo __('保存') ?></button>

<?php
echo $this->Form->end();
?>

<script>
(function(){
  if (baked.blocks.blockCode.editors[<?php echo $block['Block']['id'] ?>]) return;

  baked.blocks.blockCode.editors[<?php echo $block['Block']['id'] ?>] = CodeMirror.fromTextArea(document.getElementById("<?php echo $id ?>"), {
  mode: "application/x-ejs",
  lineNumbers: true,
  indentUnit: 2
});
})();
</script>

