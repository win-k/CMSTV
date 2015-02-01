<?php
$boxId = "bk-block-photo-image-{$block['Block']['id']}";
?>
<div id="<?php echo $boxId ?>" class="bk-block-photo-box" style="text-align: <?php echo BlockPhoto::$ALIGN[$block['Block']['data']['align']] ?>">
<?php if (!empty($block['Block']['data']['photo'])) : ?>
  <?php
  $photo = $block['Block']['data']['photo'];
  $imgUrl = sprintf('%sfiles/images/width/%d/%s.%s', URL, $block['Block']['data']['size'], $photo['code'], $photo['ext']);
  ?>
  <div class="outer"><img src="<?php echo $imgUrl ?>" id="bk-block-photo-image-<?php echo $block['Block']['id'] ?>"></div>
<?php else : ?>
  <div class="bk-note-01"><?php echo __('写真をアップロードしてください。') ?></div>
<?php endif ; ?>

  <?php if (EDITTING && !empty($block['Block']['data']['photo'])): ?>
  <script>
  $(function(){
    $('#<?php echo $boxId ?> > .outer').resizable({
      aspectRatio: true,
      handles: "s",
      minWidth: 40,
      minHeight: 40,
      maxWidth: 1000,
      stop: function(e, ui){
        baked.blocks.blockPhoto.resize(<?php echo $block['Block']['id'] ?>, ui.size);
      }
    });
  });
  </script>
  <?php endif ; ?>

</div>

