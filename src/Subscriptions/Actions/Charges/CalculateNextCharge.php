<?php

namespace Paytic\Payments\Subscriptions\Actions\Charges;

use ByTIC\DataObjects\ValueCaster;
use DateTime;
use InvalidArgumentException;
use Paytic\CommonObjects\Subscription\Billing\BillingPeriod;
use Paytic\CommonObjects\Subscription\SubscriptionInterface;
use Paytic\Payments\Models\Subscriptions\Subscription;

/**
 * Class CalculateNextCharge
 * @package Paytic\Payments\Subscriptions\Actions\Charges
 */
class CalculateNextCharge
{
    /**
     * @param Subscription $subscription
     */
    public static function for(SubscriptionInterface $subscription)
    {
        $startDate = empty($subscription->charge_at) ? $subscription->start_at : $subscription->charge_at;

        $subscription->charge_at = static::nextBillingDate(
            $startDate,
            $subscription->billing_period,
            $subscription->billing_interval
        )->format('Y-m-d H:i:s');
    }

    /**
     * @param DateTime $startDate
     * @param $period
     * @param $interval
     */
    protected static function nextBillingDate(DateTime|string $startDate, $period, $interval)
    {
        $startDate = ValueCaster::asDateTime($startDate)->setHour(8)->setMinute(0);

        switch ($period) {
            case BillingPeriod::DAILY:
                return $startDate->addDays($interval);

            case BillingPeriod::WEEKLY:
                return $startDate->addWeeks($interval);

            case BillingPeriod::MONTHLY:
                return $startDate->addMonthsNoOverflow($interval);

            case BillingPeriod::YEARLY:
                return $startDate->addYears($interval);
        }
        throw new InvalidArgumentException("Invalid period [{$period}] provided.");
    }
}
