<?php
$default = array(
  'separator' => '',
);
if (!empty($options)) $default += $options;
$tags = str_replace('/system/display/show', '', $this->Paginator->numbers($default));
?>
<?php if ($tags) : ?>
  <div class="bk-paginator"><?php echo $tags; ?></div>
<?php endif ; ?>
