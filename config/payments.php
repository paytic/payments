<?php

return [
    'models' => [
        'purchases' => 'purchases',
        'purchasesSessions' => 'purchase-sessions',
    ],
    'tables' => [
        'purchases_sessions' => 'purchases_sessions',
    ],
    'gateways' => [
        'Payu',
        'Mobilpay',
        'Euplatesc',
        'Librapay',
        'Romcard',
        'Twispay',
        'Paylike',
        'PlatiOnline'
    ],
];
