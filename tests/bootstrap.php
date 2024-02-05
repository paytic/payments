<?php

declare(strict_types=1);

use Nip\Container\Utility\Container;
use Nip\I18n\Loader\PhpFileLoader;
use Nip\I18n\Translator;

require __DIR__ . '/../vendor/autoload.php';

$configData = require dirname(__DIR__) . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'payments.php';

require dirname(__DIR__) . '/vendor/paytic/payments-tests/src/boostrap/bootstrap.php';

$container = Container::container();
$container->set('translation.languages', []);

/** @var Translator $translator */
$translator = $container->get('translator');
$translator->addLoader('php', new PhpFileLoader());
translator()->setLocale('ro');

$folder = dirname(__DIR__) . '/resources/lang/';
$languages = $container->get('translation.languages');

foreach (['ro'] as $language) {
    $path = $folder . $language;
    if (is_dir($path)) {
        $translator->addResource('php', $path, $language);
    }
}

putenv('PLATIONLINE_PUBLIC_KEY=' . gzinflate(base64_decode(envVar('PLATIONLINE_PUBLIC_KEY'))));
putenv('PLATIONLINE_PRIVATE_KEY=' . gzinflate(base64_decode(envVar('PLATIONLINE_PRIVATE_KEY'))));
