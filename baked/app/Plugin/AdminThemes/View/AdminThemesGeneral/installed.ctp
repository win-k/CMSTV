<div class="box">
  <header>
    <h1><?php echo __('インストール済みテーマ') ?></h1>
  </header>
  <div class="inner">

    <?php
    echo $this->Form->create('ThemePackage', array(
      'url' => '/admin/themes/general/installed',
    ));
    echo $this->Baked->hiddenToken();
    ?>

    <ul class="ul-themes-01">
      <?php foreach ($themePackages as $p => $themePackage) : ?>
        <?php
        $screenImg = URL.$p."/_meta/screen.png";
        ?>
        <li>
          <img src="<?php echo $screenImg ?>" class="screen">
          <div class="info">
            <div class="name">
              <label>
                <input type="radio" name="data[ThemePackage][plugin]" value="<?php echo $p ?>"><?php
                echo h($themePackage['name']);
                ?>
              </label>
            </div>
            <div class="meta">
              <?php if (!empty($themePackage['support']['pc'])) : ?>
                <span class="meta-item"><i class="icon icon-laptop"></i><?php echo __('パソコン対応') ?></span>
              <?php endif ; ?>
              <?php if (!empty($themePackage['support']['mobile'])) : ?>
                <span class="meta-item"><i class="icon icon-mobile-phone"></i><?php echo __('モバイル対応') ?></span>
              <?php endif ; ?>
            </div>
            <div class="author">
              <?php if (empty($themePackage['url'])) : ?>
                <i class="icon icon-user"></i><?php echo h(@$themePackage['author']) ?>
              <?php else : ?>
                <a href="<?php echo h($themePackage['url']) ?>" target="_blank"><i class="icon icon-user"></i><?php echo h(@$themePackage['author']) ?></a>
              <?php endif ; ?>
            </div>
          </div>

          <div class="use-in">
            <?php if ($p == $useTheme) : ?>
              <div class="use-in-pc"><?php echo __('PCテーマ'); ?></div>
            <?php endif ; ?>
            <?php if ($p == $useThemeMobile) : ?>
              <div class="use-in-mobile"><?php echo __('モバイルテーマ'); ?></div>
            <?php endif ; ?>
          </div>
        </li>
      <?php endforeach ; ?>
    </ul>

    <hr class="hr-01">

    <div class="spacer2"></div>

    <?php
    echo $this->Form->input('mode', array(
      'label' => __('選択したテーマを'),
      'options' => array(
        'set_pc' => __('PC用テーマに設定'),
        'set_mobile' => __('モバイル用テーマに設定'),
        'delete' => __('削除'),
      ),
      'empty' => TRUE,
      'div' => FALSE,
    ));
    ?>
    <button type="submit" class="button button-primary button-tiny button-pill"><?php echo __('保存') ?></button>

    <?php
    echo $this->Form->end();
    ?>

  </div>
</div>

















