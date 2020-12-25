<?php

$router->add('#^/backoffice(|/)$#', array(
    'module' => 'backoffice',
    'controller' => 'index',
    'action' => 'index',
));

$router->add('#^/backoffice/([a-zA-Z0-9\_]+)[/]{0,1}$#', array(
    'module' => 'backoffice',
    'controller' => 1,
));

$router->add('#^/backoffice[/]{0,1}([a-zA-Z0-9\_]+)/([a-zA-Z0-9\_]+)(/.*)*$#', array(
    'module' => 'backoffice',
    'controller' => 1,
    'action' => 2,
    'params' => 3,
));
