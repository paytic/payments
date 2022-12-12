<?php

use Paytic\Payments\Models\Locations\Locations;
use Paytic\Payments\Models\Methods\PaymentMethods;
use Paytic\Payments\Models\Purchases\Purchases;
use Paytic\Payments\Models\PurchaseSessions\PurchaseSessions;
use Paytic\Payments\Models\Subscriptions\Subscriptions;
use Paytic\Payments\Models\Tokens\Tokens;
use Paytic\Payments\Models\Transactions\Transactions;
use Paytic\Payments\Utility\PaymentsModels;

return [
    'models' => [
        PaymentsModels::METHODS => PaymentMethods::class,
        PaymentsModels::PURCHASES => Purchases::class,
        PaymentsModels::SESSIONS => PurchaseSessions::class,
        PaymentsModels::TOKENS => Tokens::class,
        PaymentsModels::TRANSACTIONS => Transactions::class,
        PaymentsModels::SUBSCRIPTIONS => Subscriptions::class,
        PaymentsModels::LOCATIONS => Locations::class,
    ],

    'tables' => [
        PaymentsModels::METHODS => PaymentMethods::TABLE,
        PaymentsModels::SESSIONS => PurchaseSessions::TABLE,
        PaymentsModels::TOKENS => Tokens::TABLE,
        PaymentsModels::TRANSACTIONS => Transactions::TABLE,
        PaymentsModels::SUBSCRIPTIONS => Subscriptions::TABLE,
        PaymentsModels::LOCATIONS => Locations::TABLE,
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
