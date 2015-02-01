<?php
$options = array();
foreach ($item['options'] as $option) $options[$option] = $option;
?>
<div class="input radio">
  <?php
  echo $this->Form->input("items.{$item['item_id']}", array(
    'div' => FALSE,
    'options' => $options,
    'type' => 'radio',
    'legend' => FALSE,
  ));
  ?>
</div>
