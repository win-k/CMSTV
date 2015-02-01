<?php
$title = sprintf('%s - %s', $entry['Entry']['title'], $currentMenu['Page']['title']);
$this->set('title', $title);
?>

<?php
echo $this->element('Baked/sheet', array(
  'sheet' => 'blog-header',
));
?>
<div id="entries">
  <?php
  echo $this->element('entry', array(
    'entry' => $entry,
    'full' => TRUE,
  ));
  ?>
  <div id="comments" data-bk-dynamic="comments">
    <div class="bk-block-content">
      <h3><span class="text"><?php echo __('コメント (%s)', $entry['Entry']['approved_comments_count']) ?></span></h3>
    </div>
    <div class="spacer2"></div>

    <?php if (!empty($comments)) : ?>
      <ul>
      <?php foreach ($comments as $comment) : ?>
        <li>
          <div class="name"><?php echo $comment['Comment']['name'] ?></div>
          <div class="created"><?php echo Baked::dateFormat($comment['Comment']['created'], 'Y/m/d H:i') ?></div>
          <div class="body"><?php echo nl2br(h($comment['Comment']['body'])) ?></div>
        </li>
      <?php endforeach ; ?>
      </ul>
    <?php else : ?>
      <div class="no-comments"><?php echo __('コメントはまだありません') ?></div>
    <?php endif ; ?>
    <a href="javascript:;" class="button button-add-comment" data-bk-show-comment-editor="<?php echo $entry['Entry']['id'] ?>"><?php echo __('コメントを投稿する') ?></a>
  </div>
</div>
<?php
echo $this->element('Baked/sheet', array(
  'sheet' => 'blog-footer',
));









