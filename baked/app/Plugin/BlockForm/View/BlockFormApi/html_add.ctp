<div class="bk-block-form-editor-box bk-general">
  <?php
  echo $this->Form->create('BlockForm', array(
    'default' => FALSE,
  ));
  if (!empty($this->data['BlockForm']['item_id'])) {
    echo $this->Form->input('BlockForm.item_id', array(
      'type' => 'hidden',
    ));
  }
  echo $this->Form->input('BlockForm.name', array(
    'label' => __('項目名'),
  ));
  echo $this->Form->input('BlockForm.block_id', array(
    'type' => 'hidden',
  ));
  echo $this->Form->input('BlockForm.required', array(
    'label' => __('入力必須'),
    'type' => 'checkbox',
  ));
  echo $this->Form->input('BlockForm.type', array(
    'label' => __('タイプ'),
    'options' => BlockForm::$TYPE,
    'class' => 'select-item-type',
  ));
  echo $this->Form->input('BlockForm.options_text', array(
    'label' => __('選択肢'),
    'type' => 'textarea',
    'div' => array(
      'class' => 'input options',
      'style' => 'display: none',
    ),
    'value' => isset($this->data['BlockForm']['options']) ? implode("\n", $this->data['BlockForm']['options']) : '',
  ));
  ?>

  <div class="spacer1"></div>

  <div style="height: 30px">
    <button type="submit" class="button button-primary button-pill button-small"><?php echo __('保存') ?></button>
  </div>

  <?php
  echo $this->Form->end();
  ?>
</div>

<script>
$(function(){
  baked.blocks.blockForm.setup();
});
</script>
