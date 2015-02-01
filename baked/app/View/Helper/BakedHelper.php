<?php
App::uses('AppHelper', 'View/Helper');

class BakedHelper extends AppHelper
{
  public function hiddenToken()
  {
    if (empty($_SESSION['token'])) return '';

    return sprintf('<input type="hidden" name="data[token]" value="%s">', $_SESSION['token']);
  }

  public function setElements($list)
  {
    foreach ($list as $plugin => $items) {
      if (empty($items)) continue;
      if (is_string($items)) $items = array($items);
      foreach ($items as $item) {
        echo $this->_View->element($item, array(), array(
          'plugin' => $plugin,
        ));
      }
    }
  }
}
