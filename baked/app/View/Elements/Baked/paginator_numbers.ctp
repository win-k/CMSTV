<?php
$numbers = $this->Paginator->numbers(array(
  'separator' => '',
));
?>

<?php if ($numbers) : ?>
  <div class="bk-info">
    <div class="bk-info-left"></div>
    <div class="bk-info-right">
      <?php
      echo $numbers;
      ?>
    </div>
  </div>

  <div class="spacer1"></div>
<?php endif; ?>
