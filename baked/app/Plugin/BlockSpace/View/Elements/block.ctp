<?php
$spaceId = "bk-block-space-{$block['Block']['id']}";
?>
<div id="<?php echo $spaceId ?>" class="bk-block-space" style="height: <?php echo $block['Block']['data']['size']; ?>px;"></div>

<?php if (EDITTING): ?>
<script>
$(function(){
  $('#<?php echo $spaceId ?>').resizable({
    handles: "s",
    minHeight: 10,
    maxHeight: 400,
    stop: function(e, ui){
      baked.blocks.blockSpace.resize(<?php echo $block['Block']['id'] ?>, ui.size);
    }
  });
});
</script>
<?php endif ; ?>
