<?php
// Uncomment this line if you must temporarily take down your site for maintenance.
//require __DIR__ . '/.maintenance.php';

date_default_timezone_set('Europe/Rome');
use Phalcon\Mvc\Application;

define('APP_PATH', __DIR__ . '/../');
define('ENV_TYPE',getenv('ENVIRONMENT_TYPE'));

/**
 * Composer's autoloader
 */
$loader = require APP_PATH . 'vendor/autoload.php';

/**
 * Include services
 */
require APP_PATH.'venus/Config/Services.php';

/*
* Load error handler from sentry
*/
if(file_get_contents(APP_PATH.'cache/debugip') ==  $_SERVER['REMOTE_ADDR']){
    ini_set('display_errors', 1);
    error_reporting(E_ALL);
    $client = new Raven_Client('https://aee1f9d203034b18895a7afb23eac9d1:9b72aeb6849548c586e060d74ef0f909@sentry.io/154087');

    $error_handler = new Raven_ErrorHandler($client);
    $error_handler->registerExceptionHandler();
    $error_handler->registerErrorHandler(true, E_ALL & ~E_DEPRECATED & ~E_NOTICE & ~E_USER_DEPRECATED);
    $error_handler->registerShutdownFunction();
}

try {
    /**
     * Handle the request
     */
    $application = new Application($di);

    /**
     * Assign the DI
     */
    $application->setDI($di);

    $di->set('dispatcher', function() {

    $eventsManager = new \Phalcon\Events\Manager();

    $eventsManager->attach("dispatch:beforeException", function($event, $dispatcher, $exception) {

        //Handle 404 exceptions
        if ($exception instanceof \Phalcon\Mvc\Dispatcher\Exception) {
            $dispatcher->forward(array(
                'controller' => 'end',
                'action' => 'http404'
            ));
            return false;
        }

        //Handle other exceptions
        $dispatcher->forward(array(
            'controller' => 'end',
            'action' => 'http503'
        ));

        return false;
    });

    $dispatcher = new \Phalcon\Mvc\Dispatcher();

    //Bind the EventsManager to the dispatcher
    $dispatcher->setEventsManager($eventsManager);

    return $dispatcher;

}, true);
    /**
     * Include modules
     */
    require __DIR__ . '/../venus/Config/Apps.php';

    echo $application->handle()->getContent();
} catch (Phalcon\Exception $e) {
    echo $e->getMessage();
} catch (PDOException $e) {
    echo $e->getMessage();
}
