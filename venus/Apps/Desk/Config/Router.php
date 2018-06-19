<?php
$ns = 'Venus\Apps\Desk\Controllers';
$router->add("/desk", array(
  'namespace' => $ns,
  'module'=> 'desk',
  'controller' => 'main',
  'action' => 'index'
));

$router->add("/desk/:controller", array(
  'namespace' => $ns,
  'module'=> 'desk',
  'controller' => 1,
  'action' => 'index'
));

$router->add("/desk/:controller/:action", array(
  'namespace' => $ns,
  'module'=> 'desk',
  'controller' => 1,
  'action' => 2
));

$router->add("/desk/:controller/:action/:params", array(
  'namespace' => $ns,
  'module'=> 'desk',
  'controller' => 1,
  'action' => 2,
  'params' => 3
));