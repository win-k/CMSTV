<div class="box">
  <header>
    <h1><?php echo __('基本設定') ?></h1>
  </header>
  <div class="inner">
    <?php
    echo $this->Form->create('System', array(
      'url' => '/admin/settings/general/input',
      'class' => 'form-01 bk-general',
    ));
    echo $this->Baked->hiddenToken();
    ?>
    <?php
    echo $this->Form->input(System::KEY_SITE_NAME, array(
      'label' => __('サイト名'),
    ));
    echo $this->Form->input(System::KEY_SITE_CAPTION, array(
      'label' => __('サイトの説明'),
    ));
    echo $this->Form->input(System::KEY_EMAIL, array(
      'label' => __('メールアドレス'),
      'after' => sprintf('%s%s%s', '<div class="note">', __('問い合わせフォームの宛先などに使用されます。'), '</div>'),
    ));
    $timezones = DateTimeZone::listIdentifiers();
    foreach ($timezones as $key => $timezone) {
      $timezones[$timezone] = $timezone;
      unset($timezones[$key]);
    }
    echo $this->Form->input(System::KEY_TIMEZONE, array(
      'label' => __('タイムゾーン'),
      'options' => $timezones,
      'empty' => TRUE,
    ));
    echo $this->Form->input(System::KEY_COMPANY, array(
      'label' => __('会社/団体名'),
    ));
    echo $this->Form->input(System::KEY_ADDRESS, array(
      'label' => __('住所'),
    ));
    echo $this->Form->input(System::KEY_TEL, array(
      'label' => __('電話番号'),
    ));
    ?>
    <button class="button button-primary button-pill button-small"><?php echo __('保存') ?></button>
    <?php
    echo $this->Form->end();
    ?>
  </div>
</div>
