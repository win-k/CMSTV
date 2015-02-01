<?php
$this->Html->css(Baked::read('CSS'), NULL, array('inline' => FALSE));
$this->Html->script(Baked::read('JS'), array('inline' => FALSE));
if (EDITTING) {
  $this->Html->css(Baked::read('CSS_EDITTING'), NULL, array('inline' => FALSE));
  $this->Html->script(Baked::read('JS_EDITTING'), array('inline' => FALSE));
}

