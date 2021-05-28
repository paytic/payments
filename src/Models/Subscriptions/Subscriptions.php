<?php

namespace ByTIC\Payments\Models\Subscriptions;

use ByTIC\Common\Records\Records;
use Nip\Utility\Traits\SingletonTrait;

/**
 * Class Subscriptions
 * @package ByTIC\Payments\Models\Subscriptions
 */
class Subscriptions extends Records
{
    public const TABLE = 'payments-subscriptions';

    use SingletonTrait;
    use SubscriptionsTrait;

    public function getRootNamespace()
    {
        return 'ByTIC\Payments\Models\\';
    }
}