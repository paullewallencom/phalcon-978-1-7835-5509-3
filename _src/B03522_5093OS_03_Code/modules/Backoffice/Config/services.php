<?php

$di['dispatcher'] = function () use ($di) {
    $eventsManager = $di->getShared('eventsManager');

    $dispatcher = new \Phalcon\Mvc\Dispatcher();
    $dispatcher->setEventsManager($eventsManager);
    $dispatcher->setDefaultNamespace("App\Backoffice\Controllers");

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

$di['db'] = function () use ($config) {
    return new \Phalcon\Db\Adapter\Pdo\Mysql(array(
        "host" => $config->database->host,
        "username" => $config->database->username,
        "password" => $config->database->password,
        "dbname" => $config->database->dbname,
        "options" => array(
            \PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'UTF8'",
            \PDO::ATTR_CASE => \PDO::CASE_LOWER,
            \PDO::MYSQL_ATTR_USE_BUFFERED_QUERY => true,
            \PDO::ATTR_PERSISTENT => true
        )
    ));

};
