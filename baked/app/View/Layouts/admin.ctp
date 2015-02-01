<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title><?php
  $pageTitle = '';
  if (!empty($title)) $pageTitle = $title.' - ';
  $pageTitle .= __('Baked');
  echo h($pageTitle);
?></title>

<link rel="stylesheet" href="<?php echo URL ?>css/normalize.css">
<link rel="stylesheet" href="<?php echo URL ?>css/admin.css">
<link rel="stylesheet" href="//netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.css">
<link rel="stylesheet" href="<?php echo URL ?>js/fancybox/source/jquery.fancybox.css">
<link rel="stylesheet" href="<?php echo URL ?>css/buttons.css">
<link rel="stylesheet" href="<?php echo URL ?>js/codemirror/lib/codemirror.css">
<?php
if (Baked::read('ADMIN_CSS')) {
  $this->Html->css(Baked::read('ADMIN_CSS'), NULL, array('inline' => FALSE));
}
echo $this->fetch('css');
?>

<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>
<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.9.2/jquery-ui.min.js"></script>
<script src="<?php echo URL ?>js/buttons.js"></script>
<script src="<?php echo URL ?>js/class/Baked.js"></script>
<script src="<?php echo URL ?>js/interface/baked.interface.js"></script>
<script src="<?php echo URL ?>js/fancybox/source/jquery.fancybox.js"></script>
<script src="<?php echo URL ?>js/jquery.plugins/jquery.singlesender.js"></script>
<script src="http://bp.yahooapis.com/2.4.21/browserplus-min.js"></script>
<script src="<?php echo URL ?>js/ckeditor/ckeditor.js"></script>
<script src="<?php echo URL ?>js/ckeditor/adapters/jquery.js"></script>
<script src="<?php echo URL ?>js/codemirror/lib/codemirror.js"></script>
<script src="<?php echo URL ?>js/codemirror/mode/xml/xml.js"></script>
<script src="<?php echo URL ?>js/codemirror/mode/javascript/javascript.js"></script>
<script src="<?php echo URL ?>js/codemirror/mode/php/php.js"></script>
<script src="<?php echo URL ?>js/codemirror/mode/clike/clike.js"></script>
<script src="<?php echo URL ?>js/codemirror/mode/css/css.js"></script>
<script src="<?php echo URL ?>js/codemirror/mode/htmlmixed/htmlmixed.js"></script>
<script src="<?php echo URL ?>js/codemirror/mode/htmlembedded/htmlembedded.js"></script>
<?php
if (Baked::read('ADMIN_JS')) {
  $this->Html->script(Baked::read('ADMIN_JS'), array('inline' => FALSE));
}
echo $this->fetch('script');
?>
<script>
$(function(){
  baked.base = '<?php echo URL ?>';
  baked.token = '<?php echo $_token; ?>';
  $('form').singlesender();
});
</script>
</head>
<body>

<ul id="toolbar">
  <li><a href="<?php echo URL ?>" class="sitename"><?php echo BK_SITE_NAME ?></a></li>
</ul>

<div id="wrap">

  <div id="main">
    <header class="header-01">
      <h1><i class="icon icon-large <?php echo h($adminInfo['navigation']['icon']) ?>"></i><?php echo h($adminInfo['navigation']['name']) ?></h1>
    </header>

    <?php echo $this->element('Baked/flash/type1') ?>

    <?php echo $this->fetch('content') ?>
    <?php
    ?>
  </div><!-- #main -->

</div><!-- #wrap -->

<div id="primary-navigation">
  <ul>
    <?php
    $admins = Configure::read('Admin');
    uasort($admins, function($a, $b){
      return $a['order'] > $b['order'];
    });
    ?>
    <?php foreach ($admins as $key => $admin) : ?>
      <?php
      $nav = $admin['navigation'];
      $url = URL.$nav['href'];
      $classes = array();
      if ($this->plugin == $key) $classes[] = 'current';
      ?>
      <li class="<?php echo implode(' ', $classes) ?>">
        <a href="<?php echo $url ?>"><i class="icon <?php echo $nav['icon'] ?>"></i><?php echo h($nav['name']) ?></a>
        <?php if (!empty($nav['sub'])) : ?>
          <ul>
            <?php foreach ($nav['sub'] as $nav) : ?>
              <?php
              $url = URL.$nav['href'];
              $classes = array();
              $grep = str_replace('/', "\/", $url);
              if (preg_match("/^{$grep}/i", $this->here)) $classes[] = 'current';
              ?>
              <li class="<?php echo implode(' ', $classes) ?>"><a href="<?php echo $url ?>"><?php echo h($nav['name']) ?></a></li>
            <?php endforeach ; ?>
          </ul>
        <?php endif ; ?>
      </li>
    <?php endforeach ; ?>
  </ul>
</div><!-- #primary-navigation -->


</body>
</html>

