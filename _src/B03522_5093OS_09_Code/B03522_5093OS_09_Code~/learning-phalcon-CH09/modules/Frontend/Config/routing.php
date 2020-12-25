<?php
$router->add('/', array(
    'module' => 'frontend',
    'controller' => 'index',
    'action' => 'index',
));

$router->add('#^/articles[/]{0,1}$#', array(
    'module' => 'frontend',
    'controller' => 'article',
    'action' => 'list',
));

$router->add('#^/articles/([a-zA-Z0-9\-]+)[/]{0,1}$#', array(
    'module' => 'frontend',
    'controller' => 'article',
    'action' => 'read',
    'slug' => 1,
));

$router->add('#^/categories/([a-zA-Z0-9\-]+)[/]{0,1}$#', array(
    'module' => 'frontend',
    'controller' => 'article',
    'action' => 'categories',
    'slug' => 1,
));
