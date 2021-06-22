<?php

$configData = require dirname(__DIR__) . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'payments.php';

require './vendor/bytic/payments-tests/src/boostrap/bootstrap.php';

putenv('PLATIONLINE_PUBLIC_KEY=' . gzinflate(base64_decode(envVar('PLATIONLINE_PUBLIC_KEY'))));
putenv('PLATIONLINE_PRIVATE_KEY=' . gzinflate(base64_decode(envVar('PLATIONLINE_PRIVATE_KEY'))));