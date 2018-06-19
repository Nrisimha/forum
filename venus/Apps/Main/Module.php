<?php

namespace Venus\Apps\Main;

use Phalcon\Loader;
use Phalcon\Mvc\View;
use Phalcon\DiInterface;
use Phalcon\Mvc\ModuleDefinitionInterface;
use Phalcon\Mvc\View\Engine\Volt as VoltEngine;
use Phalcon\Mvc\View\Engine\Php as PhpViewEngine;
use Alientext\Alientext;
use Phalcon\Flash\Direct as FlashDirect;
use Phalcon\Flash\Session as FlashSession;
use Shared\ViewBuilder;

class Module implements ModuleDefinitionInterface
{
    /**
    * Registers the module auto-loader
    *
    * @param DiInterface $di
    */
    public function registerAutoloaders(DiInterface $di = null)
    {
        $loader = new Loader();
        
        $loader->registerNamespaces(
        [
        'Venus\Apps\Main\Controllers' => __DIR__ . '/Controllers/',
        'Venus\Libs\Entities' => __DIR__ . '/../../Libs/Entities/',
        'Venus\Libs\Services' => __DIR__ . '/../../Libs/Services/',
        'Venus\Libs\Repositories' => __DIR__ . '/../../Libs/Repositories/'
        ]
        );
        
        $loader->register();
    }
    
    /**
    * Registers the module-only services
    *
    * @param DiInterface $di
    */
    public function registerServices(DiInterface $di)
    {
        /**
        * Read configuration
        */
        //$config = include __DIR__ . "/../../config/config.php";
        
        /**
        * Setting up the view component
        */
        $di->set(
        "view",
        function (){
            $view = new View();
            
            $view->setViewsDir(__DIR__ . '/Views/');
            
            $view->registerEngines(
            [
            ".volt" => function ($view, $di) {
                $volt = new VoltEngine($view, $di);
                
                /*$volt->getCompiler()->addFilter('txt', function ($resolvedArgs, $exprArgs) use ($di)
                {
                    return vsprintf('%s->{%s}', explode(', ', $resolvedArgs));
                }); // {{ obj|getAttribute(key) }} >>to>> <?php echo $obj->{$key}; >*/

                $voltOptions = [
                    "compiledPath"      => __DIR__ . '/../../../cache/views/',
                    "compiledSeparator" => "-",
                    "compileAlways" => true
                    ];
                if(ENV_TYPE=='production'){$voltOptions["compileAlways"] = false;}

                $volt->setOptions($voltOptions);
                
                return $volt;
            },
            
            // Generate Template files uses PHP itself as the template engine
            ".phtml" => PhpViewEngine::class
            ]
            );
            
            return $view;
        },true);

        /**
        * Alientext
        */
        $di['text'] = function() {
            return new Alientext(__DIR__ . '/Lang/');
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

        /**
        * View Builder
        */
        $di['htmlgen'] = function() {
            return new ViewBuilder();
        };




        $di['viewconf'] = include __DIR__ . "/Config/Views.php";
    }
}