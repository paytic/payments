<?php

return [
    'models' => [
        'purchases' => \ByTIC\Payments\Models\Purchases\Purchases::class,
        'purchasesSessions' => \ByTIC\Payments\Models\PurchaseSessions\PurchaseSessions::class,
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
