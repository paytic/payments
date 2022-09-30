<?php

namespace Paytic\Payments\Subscriptions\Actions\Charges;

use ByTIC\DataObjects\ValueCaster;
use DateTime;
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
        $lastAttempt = ValueCaster::asDateTime($lastAttempt);
        switch ($tries) {
            case 1:
                return $lastAttempt->addHours(3);

            case 2:
                return $lastAttempt->addDays(1);

            case 3:
                return $lastAttempt->addDays(3);

            case 4:
                return $lastAttempt->addDays(5);
        }
        return $lastAttempt->addDays($tries - 2);
    }

    protected function getTries(): int
    {
        return $this->subscription->charge_attempts > 0
            ? $this->subscription->charge_attempts
            : 1;
    }
}
