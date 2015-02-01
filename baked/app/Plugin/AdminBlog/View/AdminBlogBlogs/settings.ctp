<div class="box">
  <header>
    <h1><?php echo __('ブログ設定') ?></h1>
  </header>
  <div class="inner">

    <?php
    echo $this->Form->create('Page', array(
      'url' => "/admin/blog/blogs/settings/{$page['Page']['id']}",
      'class' => 'form-01 bk-general',
    ));
    echo $this->Baked->hiddenToken();
    ?>
    <div class="input">
      <label for="PageEntriesPerPage"><?php echo __('ブログ') ?></label>
      <a href="<?php echo $page['Page']['path'] ?>"><?php echo $page['Page']['name'] ?></a>
    </div>
    <?php
    echo $this->Form->input('entries_per_page', array(
      'label' => __('エントリ表示数'),
      'style' => 'width: 100px',
      'after' => ' '.__('件 / ページ'),
    ));
    echo $this->Form->input('can_comment', array(
      'label' => __('コメント設定'),
      'options' => Page::$CAN_COMMENT,
    ));
    echo $this->Form->input('sent_text', array(
      'label' => __('コメント送信後テキスト'),
      'type' => 'textarea',
    ));
    ?>
    <button class="button button-primary button-pill button-small"><?php echo __('保存') ?></button>
    <?php
    echo $this->Form->end();
    ?>

    <div class="spacer2"></div>

  </div>
</div>

