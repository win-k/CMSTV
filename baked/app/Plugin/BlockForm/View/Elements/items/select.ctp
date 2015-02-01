<?php
$options = array();
foreach ($item['options'] as $option) $options[$option] = $option;
echo $this->Form->input("items.{$item['item_id']}", array(
  'label' => FALSE,
  'options' => $options,
  'empty' => TRUE,
));
?>

