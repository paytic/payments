<?php

use Nip\Container\Container;

define('PROJECT_BASE_PATH', __DIR__ . '/..');
define('TEST_BASE_PATH', __DIR__);
define('TEST_FIXTURE_PATH', __DIR__ . DIRECTORY_SEPARATOR . 'fixtures');


if (file_exists(__DIR__.DIRECTORY_SEPARATOR.'.env')) {
    $dotenv = new Dotenv\Dotenv(__DIR__);
    $dotenv->load();
}

Container::getInstance()->set('inflector', \Nip\Inflector\Inflector::instance());

require dirname(__DIR__) . '/vendor/autoload.php';
