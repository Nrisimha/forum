<?php

namespace Venus\Apps\Desk;

use Phalcon\Loader;
use Phalcon\Mvc\View;
use Phalcon\DiInterface;
use Phalcon\Mvc\ModuleDefinitionInterface;
//use Phalcon\Mvc\View\Simple as SimpleView;
//use Phalcon\Mvc\View\Engine\Volt as VoltEngine;
use Phalcon\Mvc\View\Engine\Php as PhpViewEngine;
use Faker;
//use Alientext\Alientext;
//use Shared\Minitester;

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
        'Venus\Apps\Desk\Controllers' => __DIR__ . '/Controllers/'
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
        $di->set(
            "view",
            function (){
                $view = new View();
                $view->setViewsDir(__DIR__ . '/Views/');
                $view->registerEngines([".phtml" => PhpViewEngine::class]);
                return $view;
            },true);

        $di['faker'] = function() {
            $faker = new Faker\Generator();
            $faker->addProvider(new Faker\Provider\en_US\Person($faker));
            $faker->addProvider(new Faker\Provider\en_US\Address($faker));
            $faker->addProvider(new Faker\Provider\en_US\Text($faker));
            $faker->addProvider(new Faker\Provider\en_US\PhoneNumber($faker));
            $faker->addProvider(new Faker\Provider\en_US\Company($faker));
            $faker->addProvider(new Faker\Provider\Lorem($faker));
            $faker->addProvider(new Faker\Provider\Internet($faker));
            
            return $faker;
        };
    }
}