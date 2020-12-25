<?php

class Bootstrap extends \Phalcon\Mvc\Application
{
    private $modules;
    private $default_module = 'frontend';

    public function __construct($default_module)
    {
        $this->modules = array(
            'core' => array(
                'className' => 'App\Core\Module',
                'path' => __DIR__ . '/Core/Module.php'
            ),
            'api' => array(
                'className' => 'App\Api\Module',
                'path' => __DIR__ . '/Api/Module.php'
            ),
            'frontend' => array(
                'className' => 'App\Frontend\Module',
                'path' => __DIR__ . '/Frontend/Module.php'
            ),
            'backoffice' => array(
                'className' => 'App\Backoffice\Module',
                'path' => __DIR__ . '/Backoffice/Module.php'
            ),
        );

        $this->default_module = $default_module;
    }

    private function _registerServices()
    {
        $default_module = $this->default_module;
        $di             = new \Phalcon\DI\FactoryDefault();
        $config         = require __DIR__.'/../config/config.php';
        $modules        = $this->modules;

        include_once __DIR__.'/../config/loader.php';
        include_once __DIR__.'/../config/services.php';
        include_once __DIR__.'/../config/routing.php';

        $this->setDI($di);
    }

    public function init()
    {
        $debug = new \Phalcon\Debug();
        $debug->listen();

        $this->_registerServices();
        $this->registerModules($this->modules);

        echo $this->handle()->getContent();
    }
}
