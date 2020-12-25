<?php
$loader = new \Phalcon\Loader();

$loader->registerDirs(array(
    __DIR__ . '/../modules/Task/'
));

$loader->registerNamespaces(array(
    'App\Core'       => __DIR__ . '/../modules/Core/',
    'App\Frontend'   => __DIR__ . '/../modules/Frontend/',
    'App\Api'        => __DIR__ . '/../modules/Api/',
    'App\Backoffice' => __DIR__ . '/../modules/Backoffice/',
));

$loader->register();
