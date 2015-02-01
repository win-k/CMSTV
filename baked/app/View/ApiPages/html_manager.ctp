<div class="bk-general">

  <?php
  echo $this->Form->create('Page', array(
    'default' => FALSE,
    'id' => 'bk-page-manager-form',
  ));
  ?>

  <ul id="bk-page-manager">
    <?php foreach ($pages as $page) : ?>
      <li data-page-id="<?php echo $page['Page']['id'] ?>" data-page-name="<?php echo $page['Page']['name'] ?>" data-bk-depth="<?php echo $page['Page']['depth'] ?>" data-bk-hidden="<?php echo (int)$page['Page']['hidden'] ?>">
        <?php
        echo $this->Form->input("Page.{$page['Page']['id']}.title", array(
          'label' => FALSE,
          'value' => $page['Page']['title'],
          'class' => 'title',
        ));
        echo $this->Form->input("Page.{$page['Page']['id']}.name", array(
          'label' => FALSE,
          'value' => $page['Page']['name'],
          'class' => 'name',
        ));
        echo $this->Form->input("Page.{$page['Page']['id']}.order", array(
          'type' => 'hidden',
          'value' => $page['Page']['order'],
          'class' => 'order',
        ));
        echo $this->Form->input("Page.{$page['Page']['id']}.depth", array(
          'type' => 'hidden',
          'value' => $page['Page']['depth'],
          'class' => 'depth',
        ));
        echo $this->Form->input("Page.{$page['Page']['id']}.id", array(
          'type' => 'hidden',
          'value' => $page['Page']['id'],
        ));
        echo $this->Form->input("Page.{$page['Page']['id']}.hidden", array(
          'type' => 'hidden',
          'value' => (int)$page['Page']['hidden'],
          'class' => 'hidden',
        ));
        ?>
        <a href="javascript:;" class="bk-up" title="<?php echo __('このページを上へ') ?>"><i class="icon-arrow-up icon-large"></i></a>
        <a href="javascript:;" class="bk-down" title="<?php echo __('このページを下へ') ?>"><i class="icon-arrow-down icon-large"></i></a>
        <a href="javascript:;" class="bk-left" title="<?php echo __('このページを1階層上げる') ?>"><i class="icon-arrow-left icon-large"></i></a>
        <a href="javascript:;" class="bk-right" title="<?php echo __('このページを1階層下げる') ?>"><i class="icon-arrow-right icon-large"></i></a>
        <a href="javascript:;" class="bk-hide" title="<?php echo __('このページを非表示にする') ?>"><i class="icon-eye-open icon-large"></i></a>
        <a href="javascript:;" class="bk-open" title="<?php echo __('このページを表示する') ?>"><i class="icon-eye-close icon-large"></i></a>
        <a href="javascript:;" class="bk-add" title="<?php echo __('ページを追加する') ?>" data-bk-show-page-list="<?php echo $page['Page']['id'] ?>"><i class="icon-plus icon-large"></i></a>
        <a href="javascript:;" class="bk-delete" title="<?php echo __('このページを削除する') ?>"><i class="icon-trash icon-large"></i></a>
      </li>
    <?php endforeach ; ?>
  </ul>

  <div class="spacer2"></div>

  <div style="height: 30px">
    <button type="submit" class="button button-primary button-pill button-small"><?php echo __('保存') ?></button>
  </div>

  <?php
  echo $this->Form->end();
  ?>

</div>

<script>
$(function(){
  baked.alignPageManager();
  $('ul#bk-page-manager li a').powerTip();
});
</script>





