<?php
Configure::write('Blocks.BlockPhotoGallery', array(
  'name' => __('フォトギャラリー'),
  'icon' => 'icon-picture',
));

Baked::add('CSS', array(
  'BlockPhotoGallery.nivo-slider/nivo-slider.css',
  'BlockPhotoGallery.nivo-slider/themes/default/default.css',
  'BlockPhotoGallery.nivo-slider/themes/bar/bar.css',
  'BlockPhotoGallery.nivo-slider/themes/dark/dark.css',
  'BlockPhotoGallery.nivo-slider/themes/light/light.css',
));

Baked::add('JS', 'BlockPhotoGallery.jquery.nivo.slider.pack.js');

