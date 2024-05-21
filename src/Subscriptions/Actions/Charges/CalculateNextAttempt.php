<?php

namespace Paytic\Payments\Subscriptions\Actions\Charges;

use DateTime;
use Nip\Utility\Date;
use Paytic\CommonObjects\Subscription\SubscriptionInterface;
use Paytic\Payments\Models\Subscriptions\Subscription;

/**
 * Class CalculateNextAttempt
 * @package Paytic\Payments\Subscriptions\Actions\Charges
 */
class CalculateNextAttempt
{
    protected SubscriptionInterface $subscription;

    /**
     * @param SubscriptionInterface $subscription
     */
    protected function __construct(SubscriptionInterface $subscription)
    {
        $this->subscription = $subscription;
    }

    /**
     * @param Subscription $subscription
     */
    public static function for($subscription)
    {
        (new static($subscription))->execute();
    }

    protected function execute()
    {
        $this->subscription->charge_at = $this->nextAttempt(
            $this->subscription->charge_at,
            $this->getTries()
        );
    }

    /**
     * @param DateTime $startDate
     * @param $period
     * @param $interval
     */
    protected function nextAttempt($lastAttempt, $tries)
    {
//        $lastAttempt = ValueCaster::asDateTime($lastAttempt);
        $referenceDate = Date::now();
        switch ($tries) {
            case 1:
                return $referenceDate->addHours(12);

            case 2:
                return $referenceDate->addDays(3);

            case 3:
                return $referenceDate->addDays(5);

            case 4:
                return $referenceDate->addDays(10);
        }
        return $referenceDate->addDays($tries * 3);
    }

    protected function getTries(): int
    {
        return $this->subscription->charge_attempts > 0
            ? $this->subscription->charge_attempts
            : 1;
    }
}
