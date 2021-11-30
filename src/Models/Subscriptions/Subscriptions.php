<?php

namespace ByTIC\Payments\Models\Subscriptions;

use ByTIC\Payments\Models\AbstractModels\AbstractRecordManager;

/**
 * Class Subscriptions
 * @package ByTIC\Payments\Models\Subscriptions
 */
class Subscriptions extends AbstractRecordManager
{
    public const TABLE = 'payments-subscriptions';
    public const CONTROLLER = 'payments-subscriptions';

    use SubscriptionsTrait;

}
