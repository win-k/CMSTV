<?php
$commonDisplay = !empty($common) ? '1' : '0';
?>
<div id="bk-sheet-<?php echo $sheet; ?>" class="bk-sheet" data-bk-sheet="<?php echo $sheet; ?>" data-bk-common="<?php echo $commonDisplay ?>">

  <div class="bk-blocks"><?php
    foreach ($blocks as $block) :
      if ($block['Block']['sheet'] != $sheet) continue;
      echo $this->element('Baked/block', array(
        'block' => $block,
      ));
    endforeach ;
  ?></div>

  <?php if (EDITTING) : ?>
    <div class="bk-general bk-add-block-outer">
      <a href="javascript:;" class="button button-primary button-pill button-small" data-bk-show-block-list data-bk-sheet="<?php echo $sheet ?>"><?php echo __('新規ブロック') ?></a>
    </div>
  <?php endif ; ?>

</div>

