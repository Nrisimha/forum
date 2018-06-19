<?php
$router->add("/([a-z]{2})", array(
    'lang' => 1,
    'controller' => 'index',
    'action' => 'index'
));

$router->add("/([a-z]{2})/:controller", array(
    'lang' => 1,
    'controller' => 2,
    'action' => 'index'
));

$router->add("/([a-z]{2})/:controller/:action", array(
    'lang' => 1,
    'controller' => 2,
    'action' => 3
));

$router->add("/([a-z]{2})/:controller/:action/:params", array(
    'lang' => 1,
    'controller' => 2,
    'action' => 3,
    'params' => 4
));