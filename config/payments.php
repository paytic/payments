<?php

return [
    'models' => [
        'purchases' => \ByTIC\Payments\Models\Purchases\Purchases::class,
        'purchasesSessions' => \ByTIC\Payments\Models\PurchaseSessions\PurchaseSessions::class,
        'transactions' => \ByTIC\Payments\Models\Transactions\Transactions::class,
    ],

    'tables' => [
        'purchases_sessions' => 'purchases_sessions',
        'transactions' => \ByTIC\Payments\Models\Transactions\Transactions::TABLE,
        'tokens' => \ByTIC\Payments\Models\Tokens\Tokens::TABLE,
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
