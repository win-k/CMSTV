<p>
<?php echo __('Bakedの動作には下記の環境が必要です。') ?>
<?php echo __('下記の環境を設定度、このページをリロードしてください。') ?>
</p>

<div class="spacer1"></div>

<?php foreach ($environemtns as $key => $val) : ?>
  <dl class="dl-01 <?php echo ($val === TRUE) ? 'ok' : 'ng' ; ?>">
    <dt><?php echo h($key) ?></dt>
    <dd>
      <?php if ($val === TRUE) : ?>
        OK
      <?php else : ?>
        <?php echo h($val) ?>
      <?php endif ; ?>
    </dd>
  </dl>
<?php endforeach ; ?>
