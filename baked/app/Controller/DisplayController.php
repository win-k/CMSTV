<?php
App::uses('AppController', 'Controller');

class DisplayController extends AppController
{
  public $uses = array('Block', 'Page', 'Entry', 'Comment');
  public $components = array('RequestHandler');

/**
 * Displays a page
 *
 * @param mixed What page to display
 * @return void
 */
  public function show()
  {
    if (!defined('MY_CONFIGURED')) {
      $this->redirect('/system/setup/start');
    }

    $this->Page->updatePathAll();

    $path = func_get_args();
    if (count($path) == 0) $path[] = 'index';

    $this->_selectTheme();

    $menuList = $this->Page->menu($path, $currentMenu, $pageId);

    $blocks = array();
    $view;

    if (empty($currentMenu)) {
      $view = '404';
    } else {
      App::uses($currentMenu['Page']['package'], 'Lib/PagePattern');
      $PagePattern = new $currentMenu['Page']['package']($this, $path, $currentMenu);
      $PagePattern->convert();
      $view = $PagePattern->view;

      $options = $this->Block->getOptions(array(Block::OPTION_ORDER_STANDARD), array(
        CONDITIONS => array('Block.page_id' => $pageId,),
        FIELDS => array(
          'Block.id', 'Block.package', 'Block.sheet', 'Block.order', 'Block.data', 'Block.created', 'Block.modified',
        ),
      ));
      $blocks = $this->Block->find('all', $options);
      $loadedModels = array();
      foreach ($blocks as $block) {
        if (in_array($block['Block']['package'], $loadedModels)) continue;
        $this->uses[] = sprintf('%s.%s', $block['Block']['package'], $block['Block']['package']);
        $loadedModels[] = $block['Block']['package'];
        $this->{$block['Block']['package']}->create();
      }
      foreach ($blocks as &$block) {
        $block = $this->{$block['Block']['package']}->convert($block);
      }
    }

    #$this->_setupBlocks();
    Baked::setupBlocks();

    $this->set(array(
      'menuList' => $menuList,
      'currentMenu' => $currentMenu,
      'blocks' => $blocks,
    ));

    $this->layout = 'default';
    $this->render($view);
  }

  private function _selectTheme()
  {
    if ($this->RequestHandler->isMobile()) {
      $this->plugin = $this->System->value(System::KEY_USE_THEME_MOBILE);
    } else {
      $this->plugin = $this->System->value(System::KEY_USE_THEME);
    }

    Baked::loadThemePluginResources($this->plugin);
  }

}

