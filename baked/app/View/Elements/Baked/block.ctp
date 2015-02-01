<div id="bk-block-<?php echo $block['Block']['id'] ?>" class="bk-block <?php echo $block['Block']['package']; ?>" data-bk-block-id="<?php echo $block['Block']['id'] ?>" data-bk-block-package="<?php echo $block['Block']['package']; ?>">
  <div class="bk-block-content">
    <?php
    echo $this->element("{$block['Block']['package']}.block", array(
      'block' => $block,
    ));
    ?>
  </div>

  <?php if (EDITTING) : ?>
    <div class="bk-editor bk-general">
      <?php
      echo $this->element("{$block['Block']['package']}.editor", array(
        'block' => $block,
      ));
      ?>
    </div>
    <ul class="bk-controller bk-general">
      <li><a href="javascript:;" data-bk-show-block-list data-bk-sheet="<?php echo $block['Block']['sheet'] ?>" data-bk-before-block-id="<?php echo $block['Block']['id'] ?>"><i class="icon-plus icon-large"></i></a></li>
      <li><a href="javascript:;" data-bk-toggle-editor><i class="icon-folder-open icon-large"></i></a></li>
      <li><a href="javascript:;" data-bk-delete-block="<?php echo $block['Block']['id'] ?>"><i class="icon-remove icon-large"></i></a></li>
    </ul>
    <a href="javascript:;" class="bk-editor-opener" data-bk-editor-opener></a>
    <a href="javascript:;" class="bk-block-move-handle"><div class="inner"></div></a>
  <?php endif ; ?>
</div>
