<div class="box">
  <header>
    <h1><?php echo __('管理者一覧') ?></h1>
  </header>
  <div class="inner">

    <table class="table-01 list">
      <thead>
        <tr>
          <th><?php echo __('お名前') ?></th>
          <th><?php echo __('メールアドレス') ?></th>
          <th><?php echo __('登録日') ?></th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($staffs as $staff) : ?>
          <tr>
            <td><a href="<?php echo URL ?>admin/settings/staffs/add/<?php echo $staff['Staff']['id'] ?>"><?php echo h($staff['Staff']['name']) ?></a></td>
            <td><?php echo h($staff['Staff']['email']) ?></td>
            <td><?php echo Baked::dateFormat($staff['Staff']['created'], 'Y/m/d H:i') ?></td>
          </tr>
        <?php endforeach ; ?>
      </tbody>
    </table>

    <div class="spacer2"></div>

    <ul class="icon-links">
      <li><a href="<?php echo URL ?>admin/settings/staffs/add"><i class="icon-plus-sign"></i><?php echo __('追加') ?></a></li>
    </ul>

  </div>
</div>


