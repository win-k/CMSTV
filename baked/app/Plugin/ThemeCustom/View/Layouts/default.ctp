<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">

<?php echo $this->Element('Baked/head') ?>

<?php echo $this->Element('Baked/css') ?>
<link href="<?php echo URL ?>ThemeCustom/css/style.css" rel="stylesheet" type="text/css" />

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

<div id="wrap">

  <div id="primary-header">
    <a href="<?php echo URL ?>"><?php echo BK_SITE_NAME ?></a>
  </div>

  <div id="content" class="clearfix">
    <div id="main">
      <?php echo $this->fetch('content') ?>
    </div>
    <div id="sub">
      <div id="primary-navigation" data-bk-dynamic="global-navigation">
        <ul>
          <?php foreach ($menuList as $menu) : ?>
            <?php
            $classes = array();
            if ($menu['current']) $classes[] = 'current';
            ?>
            <li class="<?php echo implode(' ', $classes) ?>">
              <a href="<?php echo $menu['Page']['path'] ?>"><?php echo $menu['Page']['title'] ?></a>
              <?php if ($menu['current'] == TRUE && !empty($menu['sub'])) : ?>
                <ul>
                  <?php foreach ($menu['sub'] as $menu) : ?>
                    <?php
                    $classes = array();
                    if ($menu['current']) $classes[] = 'current';
                    ?>
                    <li class="<?php echo implode(' ', $classes) ?>">
                      <a href="<?php echo $menu['Page']['path'] ?>"><?php echo $menu['Page']['title'] ?></a>
                      <?php if ($menu['current'] == TRUE && !empty($menu['sub'])) : ?>
                        <ul>
                          <?php foreach ($menu['sub'] as $menu) : ?>
                            <?php
                            $classes = array();
                            if ($menu['current']) $classes[] = 'current';
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
      </div><!--#primary-navigation-->

      <?php
      echo $this->element('Baked/sheet', array(
        'sheet' => 'sub',
      ));
      ?>

    </div>
  </div>

</div><!-- #wrap -->

</body>
</html>





