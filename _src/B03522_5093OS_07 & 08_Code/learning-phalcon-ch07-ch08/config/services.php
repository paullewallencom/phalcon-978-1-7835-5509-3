<?php
use \Phalcon\Logger\Adapter\File as Logger;

$di['session'] = function () use ($config) {

    $session = new \Phalcon\Session\Adapter\Redis(array(
        'uniqueId' => $config->session->unique_id,
        'path' => $config->session->path,
        'name' => $config->session->name
    ));

    $session->start();

    return $session;
};

$di['security'] = function () {
    $security = new \Phalcon\Security();
    $security->setWorkFactor(12);

    return $security;
};

$di['redis'] = function () use ($config) {
    $redis = new \Redis();
    $redis->connect(
        $config->redis->host,
        $config->redis->port
    );

    return $redis;
};

$di['url'] = function () use ($config, $di) {
    $url = new \Phalcon\Mvc\Url();

    return $url;
};

$di['voltService'] = function ($view, $di) use ($config) {

    $volt = new \Phalcon\Mvc\View\Engine\Volt($view, $di);

    if (!is_dir($config->view->cache->dir)) {
        mkdir($config->view->cache->dir);
    }

    $volt->setOptions(array(
        "compiledPath" => $config->view->cache->dir,
        "compiledExtension" => ".compiled",
        "compileAlways" => true
    ));

    return $volt;
};

$di['logger'] = function () {
    $file = __DIR__."/../logs/".date("Y-m-d").".log";
    $logger = new Logger($file, array('mode' => 'w+'));

    return $logger;
};

$di['cache'] = function () use ($di, $config) {

    $frontend = new \Phalcon\Cache\Frontend\Igbinary(array(
        'lifetime' => 3600 * 24
    ));

    $cache = new \Phalcon\Cache\Backend\Redis($frontend, array(
        'redis' => $di['redis'],
        'prefix' => $config->session->name.':'
    ));

    return $cache;
};

$di['db'] = function () use ($config) {

    $connection = new \Phalcon\Db\Adapter\Pdo\Mysql(array(
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

    return $connection;
};

$di['acl'] = function () use ($di) {
    $acl = new \Phalcon\Acl\Adapter\Database([
        'db' => $di['db'],
        'roles' => 'acl_roles',
        'rolesInherits' => 'acl_roles_inherits',
        'resources' => 'acl_resources',
        'resourcesAccesses' => 'acl_resources_accesses',
        'accessList' => 'acl_access_list',
    ]);

    $acl->setDefaultAction(\Phalcon\Acl::DENY);

    return $acl;
};

$di['flash'] = function () {
    return new \Phalcon\Flash\Direct(array(
        'error'   => 'alert alert-danger alert-dismissible',
        'success' => 'alert alert-success alert-dismissible',
        'notice'  => 'alert alert-info alert-dismissible',
    ));
};

$di['flashSession'] = function () {
    return new \Phalcon\Flash\Session(array(
        'error'   => 'alert alert-danger alert-dismissible',
        'success' => 'alert alert-success alert-dismissible',
        'notice'  => 'alert alert-info alert-dismissible',
    ));
};

$di['modelsManager'] = function () {
    return new \Phalcon\Mvc\Model\Manager();
};

$di['mongo'] = function () {
    $mongo = new MongoClient();

    return $mongo->selectDB("learningPhalcon");
};

$di['collectionManager'] = function () {
    return new Phalcon\Mvc\Collection\Manager();
};

$di['modelsCache'] = $di['cache'];

$di['core_article_manager'] = function () {
    return new \App\Core\Managers\ArticleManager();
};

$di['core_user_manager'] = function () {
    return new \App\Core\Managers\UserManager();
};

$di['core_category_manager'] = function () {
    return new \App\Core\Managers\CategoryManager();
};

$di['core_hashtag_manager'] = function () {
    return new \App\Core\Managers\HashtagManager();
};
