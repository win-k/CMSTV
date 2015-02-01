<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no">
<?php echo $this->Element('Baked/head') ?>

<?php echo $this->Element('Baked/css') ?>
<link href="<?php echo URL ?>ThemeJanuary/css/style.css" rel="stylesheet" type="text/css" />

<?php echo $this->Element('Baked/js') ?>

<title><?php
  $pageTitle = '';
  if (!empty($title)) $pageTitle = $title.' - ';
  $pageTitle .= BK_SITE_NAME;
  echo h($pageTitle);
?></title>
</head>
<body>

<?php echo $this->Element('Baked/html') ?>

<div id="primary-header">
  <div class="inner">
    <a href="javascript:;" id="show-slider"><i class="icon icon-align-justify"></i></a>
    <a href="<?php echo URL ?>" class="logo"><?php echo h(BK_SITE_NAME) ?></a>
  </div>
</div>

<div id="content">
  <?php echo $this->fetch('content') ?>

  <hr>
  <div id="primary-footer">
    <div class="copy">Copyright <?php echo date('Y') ?>. All rights reserved.</div>
    <div class="powered">Powered by <a href="http://bakedcms.org/">Baked</a></div>
  </div>
</div>

<div id="slider-navigation">
  <ul data-bk-dynamic="slider-navigation">
    <?php foreach ($menuList as $menu) : ?>
      <?php
      $classes = array();
      if ($menu['current']) $classes[] = 'current';
      if ($menu['Page']['hidden']) $classes[] = 'hidden';
      ?>
      <li class="<?php echo implode(' ', $classes) ?>">
        <a href="<?php echo $menu['Page']['path'] ?>"><?php echo h($menu['Page']['title']) ?></a>
        <?php if (!empty($menu['sub'])) : ?>
          <ul>
            <?php foreach ($menu['sub'] as $menu) : ?>
              <?php
              $classes = array();
              if ($menu['current']) $classes[] = 'current';
              if ($menu['Page']['hidden']) $classes[] = 'hidden';
              ?>
              <li class="<?php echo implode(' ', $classes) ?>">
                <a href="<?php echo $menu['Page']['path'] ?>"><?php echo $menu['Page']['title'] ?></a>
                <?php if (!empty($menu['sub'])) : ?>
                <ul>
                  <?php foreach ($menu['sub'] as $menu) : ?>
                    <?php
                    $classes = array();
                    if ($menu['current']) $classes[] = 'current';
                    if ($menu['Page']['hidden']) $classes[] = 'hidden';
                    ?>
                    <li class="<?php echo implode(' ', $classes) ?>">
                      <a href="<?php echo $menu['Page']['path'] ?>"><?php echo $menu['Page']['title'] ?></a>
                    </li>
                  <?php endforeach ; ?>
                </ul>
              <?php endif ; ?>
            </li>
          <?php endforeach ; ?>
        </ul>
       <?php endif ; ?>
      </li>
    <?php endforeach ; ?>
  </ul>
</div>

</body>
</html>

