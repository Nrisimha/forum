<?php
/**
 * Services are globally registered in this file
 */


use Phalcon\Mvc\Url as UrlResolver;
use Phalcon\DI\FactoryDefault;
use Phalcon\Session\Adapter\Files as SessionAdapter;
use Phalcon\Flash\Direct as FlashDirect;
use Phalcon\Flash\Session as FlashSession;
use Shared\Locker\Session as Auth;

/**
 * The FactoryDefault Dependency Injector automatically register the right services providing a full stack framework
 */
$di = new FactoryDefault();

/**
 * Registering a router
 */
$di['router'] = function () {
    require __DIR__ . '/routes.php';
    
    return $router;
};

/**
 * The URL component is used to generate all kind of urls in the application
 */
$di['url'] = function () {
    $url = new UrlResolver();
    $url->setBaseUri('/');

    return $url;
};

/**
 * Start the session the first time some component request the session service
 */
$di['session'] = function () {
    $session = new SessionAdapter();
    $session->start();

    return $session;
};

/**
 * Custom authentication component
 */
$di['auth'] = function () {
    //$d = $this->getDI();
    return new Auth($di);
};

/**
 * Mail service uses AmazonSES
 */
//$di->set('mail', function () {
//    return new Mail();
//});

/**
 * Start the session the first time some component request the session service
 */
$di['debug'] = function () {
    class Debug{
        function add($item,$label){
            if(DEBUG == "debugbar"){
                \PhalconDebug::addMessage($item, $label);
            };
            if(DEBUG == "dump"){
                var_dump($item);
            };
        }
    };
    $debug = new Debug;
    return $debug;
};


// Set up the flash service
$di->set(
    "flash",
    function () {
        $flash = new FlashDirect(
            [
                "error"   => "alert alert-danger",
                "success" => "alert alert-success",
                "notice"  => "alert alert-info",
                "warning" => "alert alert-warning",
            ]
        );
        return $flash;
    }
);

// Set up the flash session service
$di->set(
    "flashSession",
    function () {
        return new FlashSession();
    }
);
