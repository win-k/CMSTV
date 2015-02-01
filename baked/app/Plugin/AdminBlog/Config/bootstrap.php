<?php
Configure::write('Admin.AdminBlog', array(
  'order' => 20,
  'navigation' => array(
    'name' => __('ブログ'),
    'icon' => 'icon-pencil',
    'href' => 'admin/blog/blogs/listing',
    'sub' => array(
      array(
        'name' => __('ブログ一覧'),
        'href' => 'admin/blog/blogs/listing',
      ),
      array(
        'name' => __('コメント一覧'),
        'href' => 'admin/blog/comments/listing',
      ),
    ),
  ),
));

