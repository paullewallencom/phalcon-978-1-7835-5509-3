<?php
return new \Phalcon\Config(array(
    'application' => array(
        'name' => 'Learning phalcon'
    ),
    'root_dir' => __DIR__.'/../',
    'redis' => array(
        'host' => '127.0.0.1',
        'port' => 6379,
    ),
    'session' => array(
        'unique_id' => 'learning_phalcon',
        'name' => 'learning_phalcon',
        'path' => 'tcp://127.0.0.1:6379?weight=1'
    ),
    'view' => array(
        'cache' => array(
            'dir' => __DIR__.'/../cache/volt/'
        )
    ),
    'database' => array(
        'adapter'  => 'Mysql',
        'host'     => 'localhost',
        'username' => 'root',
        'password' => 'daroot',
        'dbname'   => 'learning_phalcon',
    ),
    'apiKeys' => array(
        '6y825Oei113X3vbz78Ck7Fh7k3xF68Uc0lki41GKs2Z73032T4z8m1I81648JcrY'
    ),
    'apiUrl' => 'http://www.learning-phalcon.dev/api/v1/',
    'i18n' => [
        'locales' => [ //ISO 639-1: two-letter codes, one per language
            'en' => 'English'
        ]
    ]
));
