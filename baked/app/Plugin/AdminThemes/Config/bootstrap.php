<?php
Configure::write('Admin.AdminThemes', array(
  'order' => 10,
  'navigation' => array(
    'name' => __('テーマ'),
    'icon' => 'icon-laptop',
    'href' => 'admin/themes/general/installed',
    'sub' => array(
      array(
        'name' => __('テーマリスト'),
        'href' => 'admin/themes/general/installed',
      ),
      array(
        'name' => __('PCテーマの編集'),
        'href' => 'admin/themes/general/edit_pc',
      ),
      array(
        'name' => __('モバイルテーマの編集'),
        'href' => 'admin/themes/general/edit_mobile',
      ),
      array(
        'name' => __('テーマ検索'),
        'href' => 'admin/themes/search',
      ),
    ),
  ),
));

