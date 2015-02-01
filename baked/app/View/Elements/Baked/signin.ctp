<?php if (empty($_SESSION['Staff'])) : ?>
  <a href="<?php echo URL ?>system/signin"><?php echo __('サインイン') ?></a>
<?php elseif (!EDITTING) : ?>
  <a href="<?php echo URL ?>system/signin/editmode/1?f=<?php echo urlencode(Router::url(null, TRUE)) ?>"><?php echo __('編集モードへ') ?></a>
<?php endif ; ?>
