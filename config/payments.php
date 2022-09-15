<?php

use Paytic\Payments\Models\Methods\PaymentMethods;
use Paytic\Payments\Models\Purchases\Purchases;
use Paytic\Payments\Models\PurchaseSessions\PurchaseSessions;
use Paytic\Payments\Models\Subscriptions\Subscriptions;
use Paytic\Payments\Models\Tokens\Tokens;
use Paytic\Payments\Models\Transactions\Transactions;

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

    'database' => [
        'connection' => 'main',
        'migrations' => true,
    ],
];
