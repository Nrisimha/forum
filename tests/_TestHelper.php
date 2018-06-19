<?php

namespace Tests;
//Core
use Phalcon\Di;
use Phalcon\Di\FactoryDefault;
use Phalcon\Loader;
//Services
use Phalcon\Session\Adapter\Files as SessionAdapter;
////

ini_set("display_errors", 1);
error_reporting(E_ALL);

define("ROOT_PATH", __DIR__);

set_include_path(
    ROOT_PATH . PATH_SEPARATOR . get_include_path()
);

/**
  * Composer's autoloader
  */
define('APP_PATH', __DIR__."/../");
$loader = require APP_PATH . "vendor/autoload.php";
$loader->addPsr4('Venus\\', APP_PATH . 'venus/');
$loader->addPsr4('Pharango\\', APP_PATH . 'venus/Libs/Arangodb/src/');
$loader->addPsr4('Alientext\\', APP_PATH . 'venus/Libs/Alientext/');
$loader->addPsr4('Shared\\', APP_PATH . 'venus/Libs/');
$loader->addPsr4('Tests\\', APP_PATH . 'tests/');

// Use the application autoloader to autoload the classes
// Autoload the dependencies found in composer
$loader = new Loader();

$loader->registerDirs(
    [
        ROOT_PATH,
    ]
);

$loader->register();

$di = new FactoryDefault();

Di::reset();

//require('./_TestServices.php');

$di['session'] = function () {
    $session = new SessionAdapter();
    $session->start();

    return $session;
};

Di::setDefault($di);
