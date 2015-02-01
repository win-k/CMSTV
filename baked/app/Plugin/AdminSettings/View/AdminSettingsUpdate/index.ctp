<div class="box">
  <header>
    <h1><?php echo __('アップデート') ?></h1>
  </header>
  <div class="inner">
    <p>
      <em><?php echo __('現在のバージョン: %s', BK_VERSION) ?></em>
    </p>

    <?php if ($newVersion) : ?>
      <p>
        <strong class="color-highlight"><?php echo __('新しいバージョン %s が見つかりました。', $newVersion) ?></strong><br>
        <a href="<?php echo $dlUrl ?>" target="_blank"><i class="icon icon-download-alt"></i> <?php echo __('こちらからダウンロードすることができます。') ?></a>
      </p>

      <?php if ($autoUpdate) : ?>
        <p>
          <?php echo __('このバージョンは自動アップデートに対応しています。「自動アップデート」ボタンを押下すると、自動的にアップデートが行われます。') ?><br>
          <?php echo __('なお、アップデートには数十秒程度かかる場合がありますが、そのままお待ちください。') ?>
        </p>
        <?php
        echo $this->Form->create('Update', array(
          'url' => '/admin/settings/update/auto_update',
          'class' => 'form-01 bk-general',
        ));
        echo $this->Baked->hiddenToken();
        echo $this->Form->input('Update.version', array(
          'type' => 'hidden',
          'value' => $newVersion,
        ));
        ?>
        <button type="submit" class="button button-primary button-pill button-small"><?php echo __('自動アップデート') ?></button>
        <?php
        echo $this->Form->end();
        ?>
        <div class="spacer2"></div>
      <?php endif ; ?>
    <?php else : ?>
      <p>
        <?php echo __('アップデートはありません。') ?><br>
        <strong class="color-action"><?php echo __('Bakedは最新の状態に保たれています。') ?></strong>
      </p>
    <?php endif ; ?>

    <p>
      <a href="http://<?php echo OFFICIAL_HOST ?>/download" target="_blank"><i class="icon icon-external-link"></i> <?php echo __('バージョン一覧を表示する') ?></a>
    </p>
  </div>
</div>
