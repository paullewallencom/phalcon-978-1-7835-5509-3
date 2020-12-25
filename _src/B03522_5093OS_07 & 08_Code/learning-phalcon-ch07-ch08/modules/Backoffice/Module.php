<?php
namespace App\Backoffice;

use Phalcon\Mvc\ModuleDefinitionInterface;

class Module implements ModuleDefinitionInterface
{
    /**
     * Registers the module auto-loader
     */
    public function registerAutoloaders()
    {
    }

    /**
     * Registers the module-only services
     *
     * @param Phalcon\DI $di
     */
    public function registerServices($di)
    {
        $config = include __DIR__."/Config/config.php";
        $di['config'] = $config;
        include __DIR__."/Config/services.php";
    }
}
