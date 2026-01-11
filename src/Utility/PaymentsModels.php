<?php

namespace Paytic\Payments\Utility;

use ByTIC\PackageBase\Utility\ModelFinder;
use Nip\Records\AbstractModels\RecordManager;
use Paytic\Payments\MethodLinks\Models\PaymentMethodLinks;
use Paytic\Payments\Models\Locations\Locations;
use Paytic\Payments\Models\Methods\PaymentMethods;
use Paytic\Payments\Models\Purchases\Purchases;
use Paytic\Payments\Models\Subscriptions\Subscriptions;
use Paytic\Payments\Models\Tokens\Tokens;
use Paytic\Payments\Models\Transactions\Transactions;
use Paytic\Payments\PaymentsServiceProvider;
use Paytic\Payments\PurchaseSessions\Models\PurchaseSessions;

/**
 * Class PaymentsModels
 * @package Paytic\Payments\Utility
 */
class PaymentsModels extends ModelFinder
{
    protected static $purchaseModel = 'purchases';
    protected static $purchaseSessionsModel = 'purchase-sessions';

    public const PURCHASES = 'purchases';
    public const METHODS = 'methods';
    public const METHOD_LINKS = 'method_links';
    public const SESSIONS = 'purchases_sessions';
    public const TRANSACTIONS = 'transactions';
    public const SUBSCRIPTIONS = 'subscriptions';
    public const TOKENS = 'tokens';
    public const LOCATIONS = 'locations';

    /**
     * @return Purchases
     */
    public static function purchases(): RecordManager
    {
        return static::getModels(self::PURCHASES, Purchases::class);
    }

    /**
     * @return PaymentMethods
     */
    public static function methods(): RecordManager
    {
        return static::getModels(self::METHODS, PaymentMethods::class);
    }

    public static function methodsClass(): string
    {
        return static::getModelsClass(self::METHODS, PaymentMethods::class);
    }

    public static function methodLinks(): RecordManager
    {
        return static::getModels(self::METHOD_LINKS, PaymentMethodLinks::class);
    }

    public static function methodLinksClass(): string
    {
        return static::getModelsClass(self::METHOD_LINKS, PaymentMethodLinks::class);
    }

    /**
     * @return PurchaseSessions
     */
    public static function sessions(): RecordManager
    {
        return static::getModels(self::SESSIONS, PurchaseSessions::class);
    }

    public static function sessionsClass(): string
    {
        return static::getModelsClass(self::SESSIONS, PurchaseSessions::class);
    }

    /**
     * @return Transactions
     */
    public static function transactions(): RecordManager
    {
        return static::getModels(self::TRANSACTIONS, Transactions::class);
    }

    public static function transactionsClass(): string
    {
        return static::getModelsClass(self::TRANSACTIONS, Transactions::class);
    }

    /**
     * @return Tokens
     */
    public static function tokens(): RecordManager
    {
        return static::getModels(self::TOKENS, Tokens::class);
    }

    /**
     * @return Subscriptions
     */
    public static function subscriptions(): RecordManager
    {
        return static::getModels(self::SUBSCRIPTIONS, Subscriptions::class);
    }

    public static function subscriptionsClass(): string
    {
        return static::getModelsClass(self::SUBSCRIPTIONS, Subscriptions::class);
    }

    /**
     * @return Locations
     */
    public static function locations(): RecordManager
    {
        return static::getModels(self::LOCATIONS, Locations::class);
    }

    protected static function packageName(): string
    {
        return PaymentsServiceProvider::NAME;
    }
}
