<?php

namespace ByTIC\Payments\Models\Subscriptions;

use ByTIC\Omnipay\Common\Models\SubscriptionInterface;
use ByTIC\Payments\Utility\PaymentsModels;
use Nip\Records\AbstractModels\Record;

/**
 * Trait SubscriptionsTrait
 * @package ByTIC\Payments\Models\Subscriptions
 *
 * @method SubscriptionTrait|Subscription getNew
 */
trait SubscriptionsTrait
{

    /**
     * @return mixed|\Nip\Config\Config
     * @throws \Exception
     */
    protected function generateTable()
    {
        return config('payments.tables.subscriptions', Subscriptions::TABLE);
    }
}
