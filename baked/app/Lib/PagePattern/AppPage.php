<?php
class AppPage
{
  public $controller;
  public $path;
  public $page;
  public $view = 'show';

  public function __construct(&$controller, &$path, &$page)
  {
    $this->controller = &$controller;
    $this->path = &$path;
    $this->page = &$page;
  }

  public function convert()
  {
  }

}


