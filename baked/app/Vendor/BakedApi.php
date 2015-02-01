<?php
/**
 * BakedApi
 *
 * @author Masayuki Akiyama
 * @version 0.0.0
 */
class BakedApi
{
  private $_base = null;
  private $_error = null;

  public function __construct()
  {
    $this->_base = sprintf('http://%s/api/', OFFICIAL_HOST);
  }

  public function get($method, $args = array())
  {
    $url = $this->_base.$method;
    if ($args) $url .= '?'.http_build_query($args);

    $context = stream_context_create(array(
      'http' => array('ignore_errors' => TRUE),
    ));
    $resRaw = file_get_contents($url, FALSE, $context);
    if (strpos($http_response_header[0], '200') === FALSE) {
      $this->_error = __('正常にアクセスできませんでした');
      return FALSE;
    }

    $res = json_decode($resRaw, TRUE);

    if ($res['result'] == 'NG') {
      $this->_error = $res['message'];
      return FALSE;
    }

    return $res;
  }

  public function error()
  {
    return $this->_error;
  }

}


