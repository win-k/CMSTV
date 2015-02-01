<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>
<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.9.2/jquery-ui.min.js"></script>
<script src="<?php echo URL ?>js/class/Baked.js"></script>
<script src="<?php echo URL ?>js/interface/baked.interface.js"></script>
<script src="<?php echo URL ?>js/colorbox/jquery.colorbox-min.js"></script>
<script src="<?php echo URL ?>js/fancybox/source/jquery.fancybox.js"></script>
<script src="<?php echo URL ?>js/jquery.plugins/jquery.singlesender.js"></script>
<script src="<?php echo URL ?>js/buttons.js"></script>
<?php if (EDITTING) : ?>
  <script src="http://bp.yahooapis.com/2.4.21/browserplus-min.js"></script>
  <script src="<?php echo URL ?>js/interface/baked.editting.interface.js"></script>
  <script src="<?php echo URL ?>js/plupload/plupload.js"></script>
  <script src="<?php echo URL ?>js/plupload/plupload.gears.js"></script>
  <script src="<?php echo URL ?>js/plupload/plupload.silverlight.js"></script>
  <script src="<?php echo URL ?>js/plupload/plupload.flash.js"></script>
  <script src="<?php echo URL ?>js/plupload/plupload.browserplus.js"></script>
  <script src="<?php echo URL ?>js/plupload/plupload.html4.js"></script>
  <script src="<?php echo URL ?>js/plupload/plupload.html5.js"></script>
  <script src="<?php echo URL ?>js/plupload/jquery.ui.plupload/jquery.ui.plupload.js"></script>
  <script src="<?php echo URL ?>js/plupload/i18n/ja.js"></script>
  <script src="<?php echo URL ?>js/ckeditor/ckeditor.js"></script>
  <script src="<?php echo URL ?>js/ckeditor/adapters/jquery.js"></script>
  <script src="<?php echo URL ?>js/jquery.plugins/jquery.powertip.min.js"></script>
<?php endif ; ?>
<script>
  baked.base = '<?php echo URL ?>';
  baked.token = '<?php echo $_token; ?>';
  baked.pageId = '<?php echo $currentMenu['Page']['id'] ?>';
  $('form').singlesender();
</script>

<?php
echo $this->fetch('script');
?>

