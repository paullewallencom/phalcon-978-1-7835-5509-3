<?php

$di['dispatcher'] = function () use ($di) {
    $eventsManager = $di->getShared('eventsManager');

    $dispatcher = new \Phalcon\Mvc\Dispatcher();
    $dispatcher->setEventsManager($eventsManager);
    $dispatcher->setDefaultNamespace("App\Frontend\Controllers");

    return $dispatcher;
};

$di['url']->setBaseUri(''.$config->application->baseUri.'');

$di['view'] = function () {

    $view = new \Phalcon\Mvc\View();
    $view->setViewsDir(__DIR__ . '/../Views/Default/');
    $view->registerEngines(array(
        ".volt" => 'voltService'
    ));

    return $view;
};
