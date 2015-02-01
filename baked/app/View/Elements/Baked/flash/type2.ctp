<?php
$mes = Baked::getFlash();
?>
<?php if ($mes) : ?>
  <div class="flash-message click-to-disappear <?php echo $mes['type'] ?>"><?php echo $mes['message'] ?></div>
<?php endif ; ?>

