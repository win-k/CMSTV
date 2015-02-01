<div id="comment-editor" class="bk-general">

  <?php
  echo $this->Form->create('Comment', array(
    'id' => 'comment-editor-form',
    'default' => FALSE,
    'class' => 'bk-form-01',
  ));
  ?>
  <?php
  echo $this->Form->input('entry_id', array(
    'value' => $entry['Entry']['id'],
    'type' => 'hidden',
  ));
  echo $this->Form->input('name', array(
    'label' => __('お名前'),
  ));
  echo $this->Form->input('body', array(
    'label' => __('コメント'),
  ));
  ?>
  <button type="submit" class="button button-primary button-pill button-small"><?php echo __('投稿') ?></button>
  <?php
  echo $this->Form->end();
  ?>

</div>

