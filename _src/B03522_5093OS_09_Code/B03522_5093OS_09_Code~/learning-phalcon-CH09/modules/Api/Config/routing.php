<?php
$versions = [
    'v1' => '/api/v1',
    'v2' => '/api/v2',
];
$router->removeExtraSlashes(true);

// Articles group
$articles = new \Phalcon\Mvc\Router\Group(array(
    'module' => 'api',
    'controller' => 'articles',
));

$articles->setPrefix($versions['v1'].'/articles');

$articles->addGet('',                 ['action' => 'list']);
$articles->addGet('/{id}',            ['action' => 'get']);
$articles->addGet('/slug/{slug}',     ['action' => 'getBySlug']);
$articles->addGet('/category/{slug}', ['action' => 'getByCategorySlug']);
$articles->addPut('/{id}',            ['action' => 'update']);
$articles->addDelete('/{id}',         ['action' => 'delete']);
$articles->addPost('',                ['action' => 'create']);

$router->mount($articles);

// Hashtags group
$hashtags = new \Phalcon\Mvc\Router\Group([
    'module' => 'api',
    'controller' => 'hashtags',
]);

$hashtags->setPrefix($versions['v1'].'/hashtags');

$hashtags->addGet('',         ['action' => 'list']);
$hashtags->addGet('/{id}',    ['action' => 'get']);
$hashtags->addPut('/{id}',    ['action' => 'update']);
$hashtags->addDelete('/{id}', ['action' => 'delete']);
$hashtags->addPost('',        ['action' => 'create']);

$router->mount($hashtags);

// Categories group
$categories = new \Phalcon\Mvc\Router\Group([
    'module' => 'api',
    'controller' => 'categories',
]);

$categories->setPrefix($versions['v1'].'/categories');

$categories->addGet('',         ['action' => 'list']);
$categories->addGet('/{id}',    ['action' => 'get']);
$categories->addPut('/{id}',    ['action' => 'update']);
$categories->addDelete('/{id}', ['action' => 'delete']);
$categories->addPost('',        ['action' => 'create']);

$router->mount($categories);

// Users group
$users = new \Phalcon\Mvc\Router\Group([
    'module' => 'api',
    'controller' => 'users',
]);

$users->setPrefix($versions['v1'].'/users');

$users->addGet('',         ['action' => 'list']);
$users->addGet('/{id}',    ['action' => 'get']);
$users->addPut('/{id}',    ['action' => 'update']);
$users->addDelete('/{id}', ['action' => 'delete']);
$users->addPost('',        ['action' => 'create']);

$router->mount($users);
