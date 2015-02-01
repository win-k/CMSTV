<div class="box">
  <header>
    <h1><?php echo __('ブログ一覧') ?></h1>
  </header>
  <div class="inner">
    <?php
    echo $this->element('Baked/paginator_main');
    ?>
    <div class="spacer2"></div>

    <table class="table-01 full">
      <thead>
        <tr>
          <th><?php echo __('ブログ名') ?></th>
          <th><?php echo __('URL') ?></th>
          <th><?php echo __('新規記事') ?></th>
          <th><?php echo __('記事数') ?></th>
          <th><?php echo __('表示件数') ?></th>
          <th><?php echo __('コメント') ?></th>
          <th><?php echo __('コメント設定') ?></th>
          <th><?php echo __('設定') ?></th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($blogs as $blog) : ?>
          <tr>
            <td><a href="<?php echo URL ?>admin/blog/entries/listing/<?php echo $blog['Page']['id'] ?>"><i class="icon-file-text"></i> <?php echo h($blog['Page']['title']) ?></a></td>
            <td><a href="<?php echo $blog['Page']['path'] ?>"><i class="icon-external-link"></i> <?php echo h($blog['Page']['path']) ?></a></td>
            <td class="center"><a href="<?php echo URL ?>admin/blog/entries/add?page_id=<?php echo $blog['Page']['id'] ?>"><i class="icon-pencil"></i> <?php echo __('新規記事') ?></a></td>
            <td class="center"><?php echo number_format($blog['Page']['entries_count']) ?></td>
            <td class="center"><?php echo number_format($blog['Page']['data']['entries_per_page']) ?></td>
            <td class="center"><a href="<?php echo URL ?>admin/blog/comments/listing?page_id=<?php echo $blog['Page']['id'] ?>"><i class="icon-comment"></i> <?php echo __('全 %d 件', $blog['Page']['comments_count']) ?></a></td>
            <td class="center"><?php echo Page::$CAN_COMMENT[$blog['Page']['data']['can_comment']] ?></td>
            <td class="center"><a href="<?php echo URL ?>admin/blog/blogs/settings/<?php echo $blog['Page']['id'] ?>"><i class="icon-gear"></i> <?php echo __('設定') ?></a></td>
          </tr>
        <?php endforeach ; ?>
      </tbody>
    </table>

    <div class="spacer2"></div>

    <?php
    echo $this->element('Baked/paginator_numbers');
    ?>

  </div>
</div>

