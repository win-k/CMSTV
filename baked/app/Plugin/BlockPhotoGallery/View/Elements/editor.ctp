<?php
$uploaderId = sprintf('photo-gallary-uploader-%s', $block['Block']['id']);
?>

<?php
echo $this->Form->create('File', array(
  'default' => FALSE,
  'class' => 'bk-photo-gallery-form',
));
?>

<ul class="bk-editor-boxes">
  <li>
    <?php
    $class = array($block['Block']['data']['type'] => 'active');
    ?>
    <div class="bk-title"><?php echo __('タイプ') ?></div>
    <a href="javascript:;" class="<?php echo @$class['lightbox'] ?>"" data-bk-block-photo-gallery-set-type="lightbox"><i class="icon-th icon-2x"></i></a>
    <a href="javascript:;" class="<?php echo @$class['slider'] ?>" data-bk-block-photo-gallery-set-type="slider"><i class="icon-picture icon-2x"></i></a>
  </li>
  <li class="bk-type-lightbox">
    <div class="bk-title"><?php echo __('サイズ') ?></div>
    <a href="javascript:;" data-bk-block-photo-gallery-increase><i class="icon-plus icon-2x"></i></a>
    <a href="javascript:;" data-bk-block-photo-gallery-decrease><i class="icon-minus icon-2x"></i></a>
  </li>
  <li class="bk-type-slider">
    <div class="bk-title"><?php echo __('テーマ') ?></div>
    <?php
    echo $this->Form->input('slider_theme', array(
      'name' => 'data[slider_theme]',
      'label' => FALSE,
      'options' => BlockPhotoGallery::$SLIDER_THEME,
      'value' => $block['Block']['data']['slider_theme'],
    ));
    ?>
  </li>
  <li class="bk-type-slider">
    <div class="bk-title"><?php echo __('アニメーション') ?></div>
    <?php
    echo $this->Form->input('slider_animation', array(
      'name' => 'data[slider_animation]',
      'label' => FALSE,
      'options' => BlockPhotoGallery::$SLIDER_ANIMATION,
      'value' => $block['Block']['data']['slider_animation'],
    ));
    ?>
  </li>
  <li class="bk-type-slider">
    <div class="bk-title"><?php echo __('停止時間') ?></div>
    <?php
    echo $this->Form->input('slider_pause_time', array(
      'name' => 'data[slider_pause_time]',
      'label' => FALSE,
      'style' => 'width: 30px',
      'after' => __('秒'),
      'value' => $block['Block']['data']['slider_pause_time'],
    ));
    ?>
  </li>
  <li>
    <div class="bk-title"><?php echo __('写真一覧') ?></div>
    <a href="javascript:;" data-bk-block-photo-gallery-show-images><i class="icon-list icon-2x"></i></a>
  </li>
</ul>

<div class="block-photo-gallery-edit-list-outer" style="display: none; padding-top: 20px;">
  <ul class="block-photo-gallery-edit-list" id="bk-block-photo-gallery-edit-list-<?php echo $block['Block']['id'] ?>">
    <?php foreach (@$block['Block']['data']['photos'] as $photo) : ?>
      <?php
      $thumbUrl = sprintf('%sfiles/images/square/70/%s.%s', URL, $photo['file']['code'], $photo['file']['ext']);
      ?>
      <li style="background-image: url(<?php echo $thumbUrl ?>)" data-bk-file-id="<?php echo $photo['file_id'] ?>">
        <a href="javascript:;" class="bk-photo-gallery-delete-photo"><i class="icon-remove-sign icon-large"></i></a>
        <?php
        echo $this->Form->input("File.{$photo['file_id']}.title", array(
          'value' => $photo['title'],
        ));
        echo $this->Form->input("File.{$photo['file_id']}.alt", array(
          'value' => $photo['alt'],
        ));
        ?>
      </li>
    <?php endforeach ; ?>

    <script>
    $(function(){
      $('#bk-block-photo-gallery-edit-list-<?php echo $block['Block']['id'] ?>').sortable({
        axis: 'y',
        update: function(event, ui) {
          baked.blocks.blockPhotoGallery.saveSort(<?php echo $block['Block']['id'] ?>);
        }
      });
    });
    </script>
  </ul>
</div>

<div class="spacer2"></div>

<button type="submit" class="button button-primary button-pill button-small"><?php echo __('保存') ?></button>

<?php
echo $this->Form->end();
?>
<div class="spacer2"></div>

<div id="<?php echo $uploaderId ?>">
  <p>Your browser doesn't have Flash, Silverlight, Gears, BrowserPlus or HTML5 support.</p>
</div>

<script>
$(function(){
  baked.blocks.blockPhotoGallery.alignEditor(<?php echo $block['Block']['id'] ?>);

  (function(){
    if (baked.blocks.blockPhotoGallery.instances['<?php echo $uploaderId ?>']) return;
    baked.blocks.blockPhotoGallery.instances['<?php echo $uploaderId ?>'] =
    $('#<?php echo $uploaderId ?>').plupload({
      // General settings
      runtimes : 'html5,flash,browserplus,silverlight,gears,html4',
      url : '<?php echo URL ?>plugin/block_photo_gallery/block_photo_gallery_api/upload',
      max_file_size : '1000mb',
      max_file_count: 20, // user can add no more then 20 files at a time
      rename: true,
      multiple_queues : true,
      filters : [
        {title : "Image files", extensions : "jpg,gif,png"}
      ],
      flash_swf_url : '<?php echo URL ?>js/plupload/plupload.flash.swf',
      silverlight_xap_url : '<?php echo URL ?>js/plupload/plupload.silverlight.xap',
      init: {
        UploadComplete: function(up, files) {
          baked.blocks.blockPhotoGallery.reload(<?php echo $block['Block']['id'] ?>);
        }
      },
      multipart_params : {
        token : baked.token,
        'block_id': <?php echo $block['Block']['id'] ?>
      }
    });
  })();
});
</script>
