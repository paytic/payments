<?php

use Nip\Container\Container;

define('PROJECT_BASE_PATH', __DIR__.'/..');
define('TEST_BASE_PATH', __DIR__);
define('TEST_FIXTURE_PATH', __DIR__.DIRECTORY_SEPARATOR.'fixtures');

if (file_exists(__DIR__.DIRECTORY_SEPARATOR.'.env')) {
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
    $dotenv->load();
}

function envVar($key)
{
    if (isset($_ENV[$key])) {
        return $_ENV[$key];
    }
    return getenv($key);
}

putenv('PLATIONLINE_PUBLIC_KEY='.gzinflate(base64_decode(envVar('PLATIONLINE_PUBLIC_KEY'))));
putenv('PLATIONLINE_PRIVATE_KEY='.gzinflate(base64_decode(envVar('PLATIONLINE_PRIVATE_KEY'))));

Container::setInstance(new Container());
Container::getInstance()->set('inflector', \Nip\Inflector\Inflector::instance());

$translator = Mockery::mock(\Nip\I18n\Translator::class)->shouldAllowMockingProtectedMethods()->makePartial();
$translator->shouldReceive('persistLocale');
Container::getInstance()->set('translator', $translator);
Container::getInstance()->set('request', new \Nip\Request());

require dirname(__DIR__).'/vendor/autoload.php';
