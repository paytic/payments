<?php

namespace Paytic\Payments\Subscriptions\Actions\Charges;

use Bytic\Actions\ObservableAction;
use DateTime;
use Nip\Utility\Date;
use Paytic\CommonObjects\Subscription\SubscriptionInterface;

/**
 * Class CalculateNextCharge
 * @package Paytic\Payments\Subscriptions\Actions\Charges
 */
class ChargeIsDue extends ObservableAction
{
    protected SubscriptionInterface $subscription;
    protected $charge_at;

    public function __construct(SubscriptionInterface $subscription)
    {
        $this->subscription = $subscription;
        $this->charge_at = $subscription->charge_at;
        if (is_string($this->charge_at) && !empty($this->charge_at)) {
            $this->charge_at = Date::parse($this->charge_at);
        }
    }


    public static function for(SubscriptionInterface $subscription)
    {
        $action = new static($subscription);
        return $action->execute();
    }

    public function execute(): bool
    {
        $this->info('START ' . self::class);
        if (false === $this->subscription->canBeCharged()) {
            $this->info('END ' . self::class . ' - NOT CHARGEABLE');
            return false;
        }

        if ($this->dueIsEmpty()) {
            return false;
        }
        if (!($this->charge_at instanceof DateTime)) {
            return false;
        }

        $now = Date::now();
        if ($this->charge_at > $now) {
            return false;
        }

        return true;
    }

    protected function dueIsEmpty()
    {
        return empty($this->charge_at);
    }
}