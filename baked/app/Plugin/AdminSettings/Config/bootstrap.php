<?php
Configure::write('Admin.AdminSettings', array(
  'order' => 30,
  'navigation' => array(
    'name' => __('設定'),
    'icon' => 'icon-wrench',
    'href' => 'admin/settings/general/input',
    'sub' => array(
      array(
        'name' => __('基本設定'),
        'href' => 'admin/settings/general/input',
      ),
      array(
        'name' => __('管理者設定'),
        'href' => 'admin/settings/staffs',
      ),
      array(
        'name' => __('アップデート'),
        'href' => 'admin/settings/update',
      ),
    ),
  ),
));

