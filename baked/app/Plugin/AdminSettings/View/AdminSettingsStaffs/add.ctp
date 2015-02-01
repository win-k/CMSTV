<div class="box">
  <header>
    <h1><?php echo __('管理者詳細') ?></h1>
  </header>
  <div class="inner">
    <?php
    $url = '/admin/settings/staffs/add';
    if (!empty($staff)) $url .= "/{$staff['Staff']['id']}";
    echo $this->Form->create('Staff', array(
      'url' => $url,
      'class' => 'form-01 bk-general',
    ));
    echo $this->Baked->hiddenToken();
    ?>
    <?php
    echo $this->Form->input('name', array(
      'label' => __('お名前'),
    ));
    echo $this->Form->input('email', array(
      'label' => __('メールアドレス'),
    ));
    ?>
    <div class="input password">
      <label for="StaffPassword">パスワード</label>
      <div class="inlined">
        <?php
        if (!empty($staff)) {
          echo '<a href="javascript:;" data-toggle="#StaffPassword"><i class="icon-edit"></i>パスワードを変更</a><br>';
          if (empty($this->request->data['Staff']['password'])) {
            $style = 'display: none;';
          }
        }
        echo $this->Form->input('password', array(
          'style' => @$style,
          'div' => FALSE,
          'label' => FALSE,
        ));
        ?>
      </div>
    </div>
    <button class="button button-primary button-pill button-small"><?php echo __('保存') ?></button>
    <?php
    echo $this->Form->end();
    ?>
  </div>
</div>
