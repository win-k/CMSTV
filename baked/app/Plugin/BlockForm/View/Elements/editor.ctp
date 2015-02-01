<?php
$tableId = "block-form-editor-table-{$block['Block']['id']}";
?>
<table class="bk-block-form-editor" id="<?php echo $tableId ?>">
  <thead>
    <tr>
      <th></th>
      <th><?php echo __('項目名') ?></th>
      <th><?php echo __('対応') ?></th>
      <th><?php echo __('選択肢') ?></th>
      <th><?php echo __('必須') ?></th>
      <th></th>
    </tr>
  </thead>
  <tbody>
  <?php foreach ($block['Block']['data']['items'] as $item) : ?>
    <tr data-id="<?php echo $item['item_id'] ?>">
      <td><i class="icon-move icon-large"></i></td>
      <td><a href="javascript:;" class="bk-block-form-edit-item"><?php echo $item['name'] ?></a></td>
      <td><?php echo BlockForm::$TYPE[$item['type']] ?></td>
      <td class="bk-center"><?php echo isset($item['options']) ? count($item['options']) : '-' ?></td>
      <td class="bk-center"><?php echo $item['required'] ? '○' : '-' ?></td>
      <td><a href="javascript:;" class="bk-block-form-delete-item"><i class="icon-trash icon-large"></i></a></td>
    </tr>
  <?php endforeach ; ?>
  </tbody>
  <tfoot>
    <tr>
      <td colspan="100%"><a href="javascript:;" class="bk-block-form-add-item"><?php echo __('項目を追加する') ?></a></td>
    </tr>
  </tfoot>

  <script>
  $(function(){
    $('#<?php echo $tableId ?> > tbody').sortable({
      axis: 'y',
      helper: function(e, tr){
        var $originals = tr.children();
        var $helper = tr.clone();
        $helper.children().each(function(index){
          $(this).width($originals.eq(index).width());
        });
        return $helper;
      },
      update: function(event, ui) {
        baked.blocks.blockForm.saveSort(<?php echo $block['Block']['id'] ?>);
      }
    });
  });
  </script>
</table>

<div class="spacer1"></div>

<ul class="bk-editor-boxes">
  <li>
    <div class="bk-title"><?php echo __('送信後のテキスト') ?></div>
    <a href="javascript:;" data-bk-block-form-toggle-sent-text="open"><i class="icon-pencil icon-2x"></i></a>
  </li>
</ul>

<div class="spacer2"></div>

<?php
$id = "bk-block-form-text-{$block['Block']['id']}";
echo $this->Form->create('Block', array(
  'default' => FALSE,
  'data-block-form-editor-form',
));
echo $this->Form->input('Block.block_id', array(
  'value' => $block['Block']['id'],
  'type' => 'hidden',
));
?>
<div class="sent-text-outer" style="display: none">
  <?php
  echo $this->Form->input('Block.sent_text', array(
    'type' => 'textarea',
    'id' => $id,
    'label' => FALSE,
    'value' => $block['Block']['data']['sent_text'],
    'default' => FALSE,
    'class' => 'ckeditor-textarea',
  ));
  ?>
</div>

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





