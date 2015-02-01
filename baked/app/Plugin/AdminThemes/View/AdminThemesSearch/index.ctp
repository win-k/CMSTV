<div class="box">
  <header>
    <h1><?php echo __('テーマ検索') ?></h1>
  </header>
  <div class="inner">

    <ul class="ul-themes-02 clearfix">
      <?php foreach ($themes as $theme) : ?>
        <li>
          <img src="<?php echo $theme['capture_url'] ?>">
          <div class="cover">
            <ul class="support">
              <?php if ($theme['theme_support_pc']) :
                ?><li><i class="icon-laptop"></i> <?php echo __d('AdminThemes', 'パソコン対応') ?></li><?php
              endif;
              if ($theme['theme_support_mobile']) :
                 ?><li><i class="icon-mobile-phone"></i> <?php echo __d('AdminThemes', 'モバイル対応') ?></li>
              <?php endif ; ?>
            </ul>
            <div class="name"><?php echo h($theme['theme_name']) ?></div>
            <div class="description"><?php echo nl2br(h($theme['theme_description'])) ?></div>

            <div class="buttons">
              <span class="button-dropdown" data-buttons="dropdown">
                <button href="javascript:;" class="button button-rounded button-tiny button-flat-primary"><?php echo __d('AdminThemes', 'インストール (%d)', count($theme['variations'])) ?> <i class="icon-caret-down"></i></button>
                <ul class="button-dropdown-menu-above">
                  <?php foreach ($theme['variations'] as $themesVariation) : ?>
                    <li><a href="javascript:;" class="act-install-theme" data-theme-zip="<?php echo $themesVariation['zip_url'] ?>" data-theme-plugin="<?php echo $themesVariation['plugin'] ?>"><div class="color-box" style="background: #<?php echo $themesVariation['color_code'] ?>"></div> <?php echo h($themesVariation['name']) ?></a></li>
                  <?php endforeach ; ?>
                </ul>
              </span>
            </div>

            <div class="author">
              <?php if (empty($theme['developer_url'])) : ?>
                <i class="icon icon-user"></i> <php echo h(@$theme['developer_name']) ?>
              <?php else : ?>
                <a href="<?php echo h($theme['developer_url']) ?>" target="_blank"><i class="icon icon-user"></i> <?php echo h(@$theme['developer_name']) ?></a>
              <?php endif ; ?>
            </div>
          </div>
        </li>
      <?php endforeach ; ?>
    </ul>

  </div>
</div>

















