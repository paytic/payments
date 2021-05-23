<?php

namespace ByTIC\Payments\Application\Library\Records\Locator;

use ByTIC\Payments\Models\Methods\PaymentMethods;
use ByTIC\Payments\Models\Purchases\Purchases;
use ByTIC\Payments\Models\PurchaseSessions\PurchaseSessions;
use ByTIC\Payments\Models\Tokens\Tokens;
use ByTIC\Payments\Models\Transactions\Transactions;
use ByTIC\Payments\Utility\PaymentsModels;
use Nip\Records\AbstractModels\RecordManager;

/**
 * Trait PaymentsModelLocator
 * @package ByTIC\Payments\Application\Library\Records\Locator
 */
trait PaymentsModelLocator
{


    /**
     * @return RecordManager|Purchases
     */
    public static function paymentsPurchases(): RecordManager
    {
        return PaymentsModels::purchases();
    }

    /**
     * @return RecordManager|PaymentMethods
     */
    public static function paymentsMethods(): RecordManager
    {
        return PaymentsModels::methods();
    }

    /**
     * @return RecordManager|PurchaseSessions
     */
    public static function paymentsSessions(): RecordManager
    {
        return PaymentsModels::sessions();
    }

    /**
     * @return RecordManager|Transactions
     */
    public static function paymentsTransactions(): RecordManager
    {
        return PaymentsModels::transactions();
    }

    /**
     * @return RecordManager|Tokens
     */
    public static function paymentsTokens(): RecordManager
    {
        return PaymentsModels::tokens();
    }
}
