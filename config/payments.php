<?php

use ByTIC\Payments\Models\Methods\PaymentMethods;
use ByTIC\Payments\Models\Purchases\Purchases;
use ByTIC\Payments\Models\PurchaseSessions\PurchaseSessions;
use ByTIC\Payments\Models\Subscriptions\Subscriptions;
use ByTIC\Payments\Models\Tokens\Tokens;
use ByTIC\Payments\Models\Transactions\Transactions;

return [
    'models' => [
        'methods' => PaymentMethods::class,
        'purchases' => Purchases::class,
        'purchasesSessions' => PurchaseSessions::class,
        'tokens' => Tokens::class,
        'transactions' => Transactions::class,
        'subscriptions' => Subscriptions::class,
    ],

    'tables' => [
        'methods' => PaymentMethods::TABLE,
        'purchases_sessions' => 'purchases_sessions',
        'tokens' => Tokens::TABLE,
        'transactions' => Transactions::TABLE,
        'subscriptions' => Subscriptions::TABLE,
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
