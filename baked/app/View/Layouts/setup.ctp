<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title><?php echo h($title) ?> - <?php echo __('Baked インストーラー') ?></title>

<link rel="stylesheet" href="<?php echo URL ?>css/normalize.css">
<link rel="stylesheet" href="<?php echo URL ?>css/setup.css">
<link rel="stylesheet" href="//netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.css">
<link rel="stylesheet" href="<?php echo URL ?>css/buttons.css">

<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>
<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.9.2/jquery-ui.min.js"></script>
<script src="<?php echo URL ?>js/class/Baked.js"></script>
<script src="<?php echo URL ?>js/interface/baked.interface.js"></script>
<script src="<?php echo URL ?>js/jquery.plugins/jquery.singlesender.js"></script>
<script src="http://bp.yahooapis.com/2.4.21/browserplus-min.js"></script>
<script>
$(function(){
  $('form').singlesender();
});
</script>
</head>
<body>

<div id="wrap">

  <div id="main">
    <div id="logo"><a href="http://bakedcms.org/"><img src="<?php echo URL ?>img/logo.png"  alt="Baked" /></a></div>

    <?php echo $this->element('Baked/flash/type2') ?>

    <?php echo $this->fetch('content') ?>
  </div><!-- #main -->

</div><!-- #wrap -->

</body>
</html>


