<?php
echo $this->Form->create('Form', array(
  'default' => FALSE,
  'class' => 'bk-block-form',
  'id' => "bk-block-form-{$block['Block']['id']}",
));
?>
  <?php foreach ($block['Block']['data']['items'] as $item) : ?>
    <div class="bk-block-form-item bk-block-form-item-<?php echo $item['item_id'] ?>">
      <label class="main">
        <?php
        echo h($item['name']);
        if ($item['required']) echo '<span class="required">*</span>';
        ?>
      </label>
      <?php
      echo $this->element("BlockForm.items/{$item['type']}", array(
        'item' => $item,
      ));
      ?>
    </div>
  <?php endforeach ; ?>
  <button type="submit" class="button-send button-default"><?php echo __('送信する') ?></button>
<?php
echo $this->Form->end();
?>
