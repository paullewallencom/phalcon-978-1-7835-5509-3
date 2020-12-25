<?php
$config = require __DIR__.'/../../../config/config.php';
$module_config = array(
    'application' => array(
        'controllersDir' => __DIR__.'/../Controllers/',
        'modelsDir' => __DIR__.'/../Models/',
        'viewsDir' => __DIR__.'/../Views/',
        'baseUri' => '/backoffice/',
        'cryptSalt' => '5up3r5tr0n6p@55',
        'publicUrl' => 'http://www.learning-phalcon.dev',
    ),
    'auth' => array(
        'redirect' => array(
            'success' => 'index/index',
            'failure' => 'auth/signin',
        ),
    ),
);

$config->merge($module_config);

return $config;
