<?php
$title = NULL;
if ($currentMenu['Page']['depth'] > 0 || $currentMenu['Page']['name'] != 'index') {
  $title = $currentMenu['Page']['title'];
}
$this->set('title', $title);
?>

<div id="visual">
  <?php
  echo $this->element('Baked/sheet', array(
    'sheet' => 'visual',
  ));
  ?>
</div><!-- #visual -->

<div class="wring">

  <div id="main">
    <?php
    echo $this->element('Baked/sheet', array(
      'sheet' => 'main',
    ));
    ?>
  </div><!-- #main -->

</div><!-- .wring -->
