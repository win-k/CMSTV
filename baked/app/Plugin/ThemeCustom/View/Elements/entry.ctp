<div class="entry">
  <div class="title"><a href="<?php echo $entry['Entry']['path'] ?>"><h2><?php echo $entry['Entry']['title'] ?></h2></a></div>
  <div class="sub">
    <span class="published"><?php echo Baked::dateFormat($entry['Entry']['published'], 'F jS, Y'); ?></span><?php
    ?><span class="comments"><a href="<?php echo $entry['Entry']['path'] ?>#comments"><?php echo __('コメント') ?>(<?php echo $entry['Entry']['approved_comments_count'] ?>)</a></span>
  </div>
  <div class="body">
    <div class="body1"><?php echo $entry['Entry']['body1'] ?></div>
    <?php if (@$full) : ?>
      <div class="body2"><?php echo $entry['Entry']['body2'] ?></div>
    <?php endif ; ?>
  </div>
  <?php if (!@$full && !empty($entry['Entry']['body2'])) : ?>
    <a href="<?php echo $entry['Entry']['path'] ?>" class="more-read"><?php echo __('続きを見る') ?></a>
  <?php endif ; ?>
</div>
