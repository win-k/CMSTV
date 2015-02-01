<?php
$id = "photo-gallery-{$block['Block']['id']}-{$block['Block']['data']['type']}";
$class = "photo-gallery-{$block['Block']['id']}";
?>

<?php if ($block['Block']['data']['type'] == 'lightbox') : ?>
  <ul id="<?php echo $id ?>" class="block-photo-gallery" data-bk-type="<?php echo $block['Block']['data']['type'] ?>">

    <?php if (empty($block['Block']['data']['photos'])) : ?>
      <div class="bk-note-01"><?php echo __('写真をアップロードしてください。') ?></div>
    <?php endif ; ?>

    <?php foreach (@$block['Block']['data']['photos'] as $photo) :
      $originalUrl = sprintf('%sfiles/images/width/600/%s.%s', URL, $photo['file']['code'], $photo['file']['ext']);
      $thumbUrl = sprintf('%sfiles/images/square/%d/%s.%s', URL, $block['Block']['data']['width'], $photo['file']['code'], $photo['file']['ext']);
      $title = !empty($photo['title']) ? $photo['title'] : '';
      $alt = !empty($photo['alt']) ? $photo['alt'] : '';
      ?><li><a class="<?php echo $class ?>" href="<?php echo $originalUrl ?>" title="<?php echo $title ?>"><img src="<?php echo $thumbUrl ?>" alt="<?php echo $alt ?>"></a></li><?php
    endforeach ; ?>

    <script>
    $(function(){
      $('a.<?php echo $class ?>').colorbox({rel:'<?php echo $class ?>',maxWidth:'100%',maxHeight:'100%'});
    });
    </script>
  </ul>
<?php endif ; ?>

<?php if ($block['Block']['data']['type'] == 'slider') : ?>
  <div id="<?php echo $id ?>" class="block-photo-gallery slider-wrapper theme-<?php echo $block['Block']['data']['slider_theme'] ?>" data-bk-type="<?php echo $block['Block']['data']['type'] ?>">
    <div class="nivoSlider">
      <?php foreach (@$block['Block']['data']['photos'] as $photo) : ?>
        <?php
        $originalUrl = sprintf('%sfiles/%s', URL, $photo['file']['path']);
        $title = !empty($photo['title']) ? $photo['title'] : '';
        $alt = !empty($photo['alt']) ? $photo['alt'] : '';
        ?>
        <img src="<?php echo $originalUrl ?>" alt="<?php echo $alt ?>", title="<?php echo $title ?>">
      <?php endforeach ; ?>
    </div>

    <script>
    $(function(){
      $('#<?php echo $id ?> > div.nivoSlider').nivoSlider({
        pauseTime: <?php echo $block['Block']['data']['slider_pause_time']*1000 ?>,
        effect: '<?php echo $block['Block']['data']['slider_animation'] ?>'
      });
    });
    </script>

  </div>
<?php endif ; ?>
