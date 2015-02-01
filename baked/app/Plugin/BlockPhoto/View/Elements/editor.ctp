<?php
$uploaderId = sprintf('bk-block-photo-uploader-%s', $block['Block']['id']);
?>

<ul class="bk-editor-boxes">
  <li>
    <div class="bk-title"><?php echo __('位置') ?></div>
    <a href="javascript:;" data-bk-block-photo-align="1"><i class="icon-align-left icon-2x"></i></a>
    <a href="javascript:;" data-bk-block-photo-align="2"><i class="icon-align-center icon-2x"></i></a>
    <a href="javascript:;" data-bk-block-photo-align="3"><i class="icon-align-right icon-2x"></i></a>
  </li>
</ul>

<div class="spacer1"></div>

<div id="<?php echo $uploaderId ?>">
  <p><?php echo __("Your browser doesn't have Flash, Silverlight, Gears, BrowserPlus or HTML5 support.") ?></p>
</div>

<script>
$(function(){
  (function(){
    if (baked.blocks.blockPhoto.instances['<?php echo $uploaderId ?>']) return;
    baked.blocks.blockPhoto.instances['<?php echo $uploaderId ?>'] =
    $('#<?php echo $uploaderId ?>').plupload({
      runtimes : 'html5,flash,browserplus,silverlight,gears,html4',
      url : '<?php echo URL ?>plugin/block_photo/block_photo_api/upload',
      max_file_size : '1000mb',
      rename: true,
      multi_selection: false,
      rename: true,
      filters : [
        {title : "Image files", extensions : "jpg,gif,png"}
      ],
      flash_swf_url : '<?php echo URL ?>js/plupload/plupload.flash.swf',
      silverlight_xap_url : '<?php echo URL ?>js/plupload/plupload.silverlight.xap',
      init: {
        UploadComplete: function(up, files) {
          baked.blocks.blockPhoto.reload(<?php echo $block['Block']['id'] ?>);
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

