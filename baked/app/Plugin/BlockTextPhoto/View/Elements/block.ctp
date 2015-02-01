<div class="bk-block-text-photo-content">
  <?php
  $photoBoxId = "bk-block-text-photo-image-{$block['Block']['id']}";
  ?>
  <div id="<?php echo $photoBoxId ?>" class="bk-block-text-photo-image-box <?php echo BlockTextPhoto::$ALIGN[$block['Block']['data']['align']] ?>">
  <?php if (!empty($block['Block']['data']['photo'])) : ?>
    <?php
    $photo = $block['Block']['data']['photo'];
    $imgUrl = sprintf('%sfiles/images/width/%d/%s.%s', URL, $block['Block']['data']['size'], $photo['code'], $photo['ext']);
    ?>
    <img src="<?php echo $imgUrl ?>">
  <?php endif ; ?>

    <?php if (EDITTING && !empty($block['Block']['data']['photo'])): ?>
    <script>
    $(function(){
      $('#<?php echo $photoBoxId ?>').resizable({
        aspectRatio: true,
        handles: "s",
        minWidth: 40,
        minHeight: 40,
        maxWidth: 1000,
        stop: function(e, ui){
          baked.blocks.blockTextPhoto.resize(<?php echo $block['Block']['id'] ?>, ui.size);
        }
      });
    });
    </script>
    <?php endif ; ?>
  </div>

  <?php echo $block['Block']['data']['text'] ?>

</div>
