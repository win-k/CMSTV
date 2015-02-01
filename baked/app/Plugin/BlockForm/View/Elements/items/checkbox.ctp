<?php
$options = array();
foreach ($item['options'] as $option) $options[$option] = $option;
?>
<div class="input">
  <?php
  $i = 0;
  foreach ($options as $option) :
    $chechId = "Items{$item['item_id']}-{$i}";
    ?>
    <div class="checkbox">
      <input type="checkbox" name="data[items][<?php echo $item['item_id'] ?>][<?php echo $i ?>]" value="<?php echo h($option) ?>" id="<?php echo $chechId ?>"><label for="<?php echo $chechId ?>"><?php echo h($option) ?></label>
    </div>
    <?php
    $i++;
  endforeach ;
  ?>
</div>
