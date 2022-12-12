<?php

declare(strict_types=1);

use Nip\Container\Utility\Container;

require __DIR__ . '/../vendor/autoload.php';

$configData = require dirname(__DIR__) . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'payments.php';

require dirname(__DIR__) . '/vendor/paytic/payments-tests/src/boostrap/bootstrap.php';

Container::container()->set('translation.languages', []);
translator()->setLocale('ro');

putenv('PLATIONLINE_PUBLIC_KEY=' . gzinflate(base64_decode(envVar('PLATIONLINE_PUBLIC_KEY'))));
putenv('PLATIONLINE_PRIVATE_KEY=' . gzinflate(base64_decode(envVar('PLATIONLINE_PRIVATE_KEY'))));
