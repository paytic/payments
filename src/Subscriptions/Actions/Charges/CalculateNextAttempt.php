<?php

namespace Paytic\Payments\Subscriptions\Actions\Charges;

use DateTime;
use Paytic\Payments\Models\Subscriptions\Subscription;

/**
 * Class CalculateNextAttempt
 * @package Paytic\Payments\Subscriptions\Actions\Charges
 */
class CalculateNextAttempt
{
    /**
     * @param Subscription $subscription
     */
    public static function for($subscription)
    {
        $count = $subscription->charge_attempts > 0 ? $subscription->charge_attempts : 1;
        $subscription->charge_at = static::nextAttempt(
            $subscription->charge_at,
            $count
        );
    }

    /**
     * @param DateTime $startDate
     * @param $period
     * @param $interval
     */
    protected static function nextAttempt(DateTime $lastAttempt, $tries)
    {
        switch ($tries) {
            case 1:
                return $lastAttempt->addHours(3);

            case 2:
                return $lastAttempt->addHours(12);

            case 3:
                return $lastAttempt->addDays(1);

            case 4:
                return $lastAttempt->addDays(2);
        }
        return $lastAttempt->addDays($tries - 2);
    }
}
