<?php echo __('お問い合わせがありました。') ?>


--

IP: <?php echo $_SERVER["REMOTE_ADDR"]; ?>


<?php foreach ($items as $item) : ?>
◆<?php echo $item['item']['name'] ?>

<?php
$value = is_array($item['value']) ? implode(', ', $item['value']) : $item['value'] ;
echo $value;
?>


<?php endforeach ; ?>
--

