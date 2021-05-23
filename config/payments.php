<?php

use ByTIC\Payments\Models\Methods\PaymentMethods;
use ByTIC\Payments\Models\Purchases\Purchases;
use ByTIC\Payments\Models\PurchaseSessions\PurchaseSessions;
use ByTIC\Payments\Models\Transactions\Transactions;

return [
    'models' => [
        'purchases' => Purchases::class,
        'purchasesSessions' => PurchaseSessions::class,
        'transactions' => Transactions::class,
        'methods' => PaymentMethods::class,
    ],

    'tables' => [
        'purchases_sessions' => 'purchases_sessions',
        'methods' => PaymentMethods::TABLE,
        'transactions' => Transactions::TABLE,
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
