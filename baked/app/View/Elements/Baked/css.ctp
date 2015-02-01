<link href="<?php echo URL ?>css/normalize.css" rel="stylesheet" type="text/css">
<link href="<?php echo URL ?>css/baked.css" rel="stylesheet" type="text/css">
<link href="//ajax.googleapis.com/ajax/libs/jqueryui/1.9.2/themes/base/jquery-ui.css" rel="stylesheet" type="text/css">
<link href="//netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.css" rel="stylesheet">
<link href="<?php echo URL ?>js/colorbox/colorbox.css" rel="stylesheet" type="text/css">
<link href="<?php echo URL ?>js/fancybox/source/jquery.fancybox.css" rel="stylesheet" type="text/css">
<link href="<?php echo URL ?>css/buttons.css" rel="stylesheet" type="text/css">

<?php if (EDITTING) : ?>
  <link href="<?php echo URL ?>js/plupload/jquery.ui.plupload/css/jquery.ui.plupload.css" rel="stylesheet" type="text/css">
  <link href="<?php echo URL ?>css/editor.css" rel="stylesheet" type="text/css">
  <link href="<?php echo URL ?>css/powertip/jquery.powertip.min.css" rel="stylesheet" type="text/css">
<?php endif ; ?>

<?php
echo $this->fetch('css');
?>
