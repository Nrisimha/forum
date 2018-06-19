<?php
/**
 * Services are globally registered in this file
 */

use ArangoDBClient\Connection;
use ArangoDBClient\ConnectionOptions;
use ArangoDBClient\UpdatePolicy;
use Phalcon\Filter;
use Phalcon\Mvc\Url as UrlResolver;
use Phalcon\DI\FactoryDefault;
use Phalcon\Session\Adapter\Files as SessionAdapter;
use Shared\Locker\Session as Locker;
use Shared\SlowDown;
use Shared\Minitester;
use Shared\ViewBuilder;

/**
 * The FactoryDefault Dependency Injector automatically register the right services providing a full stack framework
 */
$di = new FactoryDefault();

/**
 * Registering a router
 */
$di['router'] = function () {
    require __DIR__ . '/Router.php';
    
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

$di['locker'] = function () {
    return new Locker();
};

/**
 * Mail service uses AmazonSES
 */
//$di->set('mail', function () {
//    return new Mail();
//});

/*
 * Start the session the first time some component request the session service
 *
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

/**
* Minitester
*/
$di['u'] = function() {
    return new Minitester('<br />');
};


/**
* Slowdown
*/
$di['slowdown'] = function() {
    return new SlowDown();
};


// Set up the filter service
$di->set(
    "filter",
    function () {
        $filter = new Filter();

        $filter->add(
            "md5",
            function ($value) {
                return preg_replace("/[^0-9a-f]/", "", $value);
            }
        );

        return $filter;
    }
);

// Set up the flash session service
$di->set(
    "flashSession",
    function () {
        return new FlashSession();
    }
);

// Set up the db connection
$di->setShared(
    "connection",
    function () {
    try{
        $connectionOptions = array(
            ConnectionOptions::OPTION_ENDPOINT => getenv('DBURL'),
            ConnectionOptions::OPTION_AUTH_USER => getenv('DBUSER'),
            ConnectionOptions::OPTION_AUTH_PASSWD => getenv('DBPASS'),
            ConnectionOptions::OPTION_AUTH_TYPE => 'Basic', // only option is Basic
            ConnectionOptions::OPTION_DATABASE => 'helium',
            ConnectionOptions::OPTION_CONNECTION => 'Keep-Alive', // Close or Keep-Alive
            ConnectionOptions::OPTION_TIMEOUT => 3, // seconds
            ConnectionOptions::OPTION_RECONNECT => true,
            // optionally create new collections when inserting documents
            ConnectionOptions::OPTION_CREATE => true,
            ConnectionOptions::OPTION_UPDATE_POLICY => UpdatePolicy::LAST,
        );
    return new Connection($connectionOptions);
    } catch (Exception $e) {
        echo $e->getMessage();
    }
    }
);

