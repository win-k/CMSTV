<?php
$id = "bk-block-text-photo-textarea-{$block['Block']['id']}";
echo $this->Form->create('Block', array(
  'default' => FALSE,
  'data-block-editor-text-photo',
));
?>
<textarea name="text" id="<?php echo $id ?>" class="ckeditor-textarea"><?php echo $block['Block']['data']['text'] ?></textarea>

<div class="spacer1"></div>

<button type="submit" class="button button-primary button-pill button-small"><?php echo __('保存') ?></button>

<?php
echo $this->Form->end();
?>

<div class="spacer1"></div>

<?php
$uploaderId = sprintf('bk-block-text-photo-uploader-%s', $block['Block']['id']);
?>

<ul class="bk-editor-boxes">
  <li>
    <div class="bk-title"><?php echo __('写真の位置') ?></div>
    <a href="javascript:;" data-bk-block-text-photo-align="1"><i class="icon-align-left icon-2x"></i></a>
    <a href="javascript:;" data-bk-block-text-photo-align="2"><i class="icon-align-right icon-2x"></i></a>
  </li>
</ul>

<div class="spacer1"></div>

<div id="<?php echo $uploaderId ?>">
  <p><?php echo __("Your browser doesn't have Flash, Silverlight, Gears, BrowserPlus or HTML5 support.") ?></p>
</div>

<script>
$(function(){
  $('#<?php echo $id ?>').bkCkeditor();

  (function(){
    if (baked.blocks.blockTextPhoto.instances['<?php echo $uploaderId ?>']) return;
    baked.blocks.blockTextPhoto.instances['<?php echo $uploaderId ?>'] =
    $('#<?php echo $uploaderId ?>').plupload({
      runtimes : 'html5,flash,browserplus,silverlight,gears,html4',
      url : '<?php echo URL ?>plugin/block_text_photo/block_text_photo_api/upload',
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
          baked.blocks.blockTextPhoto.reload(<?php echo $block['Block']['id'] ?>);
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

