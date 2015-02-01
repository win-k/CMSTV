<?php
Configure::write('Blocks.BlockCode', array(
  'name' => __('コード'),
  'icon' => 'icon-code',
));

Baked::add('CSS_EDITTING', '/js/codemirror/lib/codemirror.css');
Baked::add('JS_EDITTING', 'codemirror/lib/codemirror.js');
Baked::add('JS_EDITTING', array(
  'codemirror/mode/xml/xml.js',
  'codemirror/mode/javascript/javascript.js',
  'codemirror/mode/css/css.js',
  'codemirror/mode/htmlmixed/htmlmixed.js',
  'codemirror/mode/htmlembedded/htmlembedded.js',
));
