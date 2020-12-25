<?php

$di['router'] = function () use ($default_module, $modules, $di, $config) {

    $router = new \Phalcon\Mvc\Router(false);
    $router->clear();

    $moduleRouting = __DIR__.'/../modules/'.ucfirst($default_module).'/Config/routing.php';

    if (file_exists($moduleRouting) && is_file($moduleRouting)) {
        include $moduleRouting;
    } else {
        $router->add('#^/(|/)$#', array(
            'module' => $default_module,
            'controller' => 'index',
            'action' => 'index',
        ));

        $router->add('#^/([a-zA-Z0-9\_]+)[/]{0,1}$#', array(
            'module' => $default_module,
            'controller' => 1,
        ));

        $router->add('#^/{0,1}([a-zA-Z0-9\_]+)/([a-zA-Z0-9\_]+)(/.*)*$#', array(
            'module' => $default_module,
            'controller' => 1,
            'action' => 2,
            'params' => 3,
        ));
    }

    foreach ($modules as $moduleName => $module) {
        if ($default_module == $moduleName) {
            continue;
        }

        $moduleRouting = __DIR__.'/../modules/'.ucfirst($moduleName).'/Config/routing.php';

        if (file_exists($moduleRouting) && is_file($moduleRouting)) {
            include $moduleRouting;
        }
    }

    return $router;
};
