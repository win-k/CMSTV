<?php
class AdminThemesSearchController extends AdminThemesAppController
{
  public $uses = array('ThemePackage', 'System');

  public function index()
  {
    $this->title = __('テーマ検索');

    App::uses('BakedApi', 'Vendor');
    $bakedApi = new BakedApi;

    $themes = FALSE;
    $paging = FALSE;

    $page = isset($this->request->query['page']) ? $this->request->query['page'] : 1 ;
    $results = $bakedApi->get('themes/search', array(
      'page' => $page,
    ));

    if ($results) {
      $themes = $results['themes'];
      $paging = $results['paging'];
    }

    $this->set(array(
      'themes' => $themes,
      'paging' => $paging,
    ));
  }

}

