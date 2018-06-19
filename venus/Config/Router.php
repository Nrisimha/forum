<?php

use Phalcon\Mvc\Router;
$router = new Router();

$router->setDefaultModule("main");
$router->setDefaultNamespace("Venus\Apps\Main\Controllers");

$router->setUriSource(\Phalcon\Mvc\Router::URI_SOURCE_SERVER_REQUEST_URI);

$router->removeExtraSlashes(true);

include __DIR__ . '/../Apps/Main/Config/Router.php';