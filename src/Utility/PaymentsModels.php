<?php

namespace Paytic\Payments\Utility;

use Nip\Records\AbstractModels\RecordManager;
use Nip\Records\Locator\ModelLocator;
use Paytic\Payments\Models\Locations\Locations;
use Paytic\Payments\Models\Methods\PaymentMethods;
use Paytic\Payments\Models\Purchases\Purchases;
use Paytic\Payments\Models\PurchaseSessions\PurchaseSessions;
use Paytic\Payments\Models\Subscriptions\Subscriptions;
use Paytic\Payments\Models\Tokens\Tokens;
use Paytic\Payments\Models\Transactions\Transactions;

/**
 * Class PaymentsModels
 * @package Paytic\Payments\Utility
 */
class PaymentsModels
{
    protected static $purchaseModel = 'purchases';
    protected static $purchaseSessionsModel = 'purchase-sessions';

    protected static $models = [];

    public const PURCHASES = 'purchases';
    public const METHODS = 'methods';
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

    /**
     * @return PurchaseSessions
     */
    public static function sessions(): RecordManager
    {
        return static::getModels(self::SESSIONS, PurchaseSessions::class);
    }

    /**
     * @return Transactions
     */
    public static function transactions(): RecordManager
    {
        return static::getModels(self::TRANSACTIONS, Transactions::class);
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

    /**
     * @return Locations
     */
    public static function locations(): RecordManager
    {
        return static::getModels(self::LOCATIONS, Locations::class);
    }

    public static function reset()
    {
        static::$models = [];
    }

    /**
     * @param string $type
     * @param string $default
     * @return mixed|RecordManager
     */
    protected static function getModels($type, $default)
    {
        if (!isset(static::$models[$type])) {
            $modelManager = static::getConfigVar($type, $default);
            return static::$models[$type] = ModelLocator::get($modelManager);
        }

        return static::$models[$type];
    }

    /**
     * @param string $type
     * @param null|string $default
     * @return string
     */
    protected static function getConfigVar($type, $default = null)
    {
        if (!function_exists('config')) {
            return $default;
        }
        $varName = 'payments.models.' . $type;
        $config = config();
        if ($config->has($varName)) {
            return $config->get($varName);
        }
        return $default;
    }
}
