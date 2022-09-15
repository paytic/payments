<?php

namespace Paytic\Payments\Models\Subscriptions;

use Paytic\Payments\Models\AbstractModels\AbstractRecordManager;

/**
 * Class Subscriptions
 * @package Paytic\Payments\Models\Subscriptions
 */
class Subscriptions extends AbstractRecordManager
{
    public const TABLE = 'payments-subscriptions';
    public const CONTROLLER = 'payments-subscriptions';

    use SubscriptionsTrait;
}
