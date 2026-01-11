<?php

namespace Paytic\Payments\Application\Library\Records\Locator;

use Nip\Records\AbstractModels\RecordManager;
use Paytic\Payments\Models\Methods\PaymentMethods;
use Paytic\Payments\Models\Purchases\Purchases;
use Paytic\Payments\Models\Tokens\Tokens;
use Paytic\Payments\Models\Transactions\Transactions;
use Paytic\Payments\PurchaseSessions\Models\PurchaseSessions;
use Paytic\Payments\Utility\PaymentsModels;

/**
 * Trait PaymentsModelLocator
 * @package Paytic\Payments\Application\Library\Records\Locator
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
