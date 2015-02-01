<?php
$mes = Baked::getFlash();
?>
<?php if ($mes) : ?>
  <div class="click-to-disappear">
    <div class="flash-message <?php echo $mes['type'] ?>"><?php echo $mes['message'] ?></div>
    <div class="spacer2"></div>
  </div>
<?php endif ; ?>

