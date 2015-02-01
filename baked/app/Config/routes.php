<?php
Router::connect('/system/:controller/:action/*');
Router::connect('/system/:controller/*');
Router::connect('/files/:action/*', array('controller' => 'files'));
Router::connect('/plugin/:plugin/:controller/:action/*');

$req = Router::getRequest();

if (preg_match('/^admin\/(.+)/i', $req->url, $matches)) {
  $pathes = explode('/', $matches[1]);
  Router::connect("/{$req->url}", array(
    'plugin' => "admin_{$pathes[0]}",
    'controller' => "admin_{$pathes[0]}_{$pathes[1]}",
    'action' => !empty($pathes[2]) ? $pathes[2] : 'index',
  )+@array_slice($pathes, 3));
}

Router::connect('/', array('controller' => 'display', 'action' => 'show'));
Router::connect('/*', array('controller' => 'display', 'action' => 'show'));
Router::connect('/*/*', array('controller' => 'display', 'action' => 'show'));

CakePlugin::routes();

require CAKE . 'Config' . DS . 'routes.php';
