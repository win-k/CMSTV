<?php if (EDITTING) : ?>
  <ul id="bk-available-blocks" class="bk-general ul-01">
    <?php foreach (Configure::read('Blocks') as $plugin => $info) : ?>
      <li><a href="javascript:;" data-bk-add-block="<?php echo $plugin ?>"><?php if (isset($info['icon'])) echo sprintf('<i class="icon %s"></i>', $info['icon']); ?><?php echo $info['name'] ?></a></li>
    <?php endforeach ; ?>
  </ul>

  <ul id="bk-available-pages" class="bk-general ul-01">
    <li><a href="javascript:;" data-bk-add-page="PagePlain"><i class="icon-file-alt"></i><?php echo __('空白ページ') ?></a></li>
    <li><a href="javascript:;" data-bk-add-page="PageBlog"><i class="icon-edit-sign"></i><?php echo __('ブログ') ?></a></li>
  </ul>

  <ul id="bk-toolbar" class="bk-general">
    <li><a href="<?php echo URL ?>admin/themes/general/installed"><?php echo __('管理画面') ?></a></li>
    <li><a href="javascript:;" data-bk-show-page-manager><?php echo __('ページ管理') ?></a></li>
    <?php if ($currentMenu['Page']['package'] == 'PageBlog') : ?>
      <li><a href="<?php echo URL ?>admin/blog/entries/add?page_id=<?php echo $currentMenu['Page']['id'] ?>"><?php echo h(__('"%s"に新規投稿', $currentMenu['Page']['title'])) ?></a></li>
      <li><a href="<?php echo URL ?>admin/blog/entries/listing/<?php echo $currentMenu['Page']['id'] ?>"><?php echo h(__('"%s"の記事一覧', $currentMenu['Page']['title'])) ?></a></li>
    <?php endif ; ?>
    <li><a href="javascript:;" class="bk-cancel-editmode"><?php echo __('編集モード終了') ?></a></li>
    <li><a href="javascript:;" class="bk-sign-out"><?php echo __('サインアウト') ?></a></li>
  </ul>
<?php endif ; ?>


