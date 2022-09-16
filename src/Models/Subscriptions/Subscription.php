<?php

namespace Paytic\Payments\Models\Subscriptions;

use Paytic\CommonObjects\Subscription\SubscriptionInterface;
use Paytic\Payments\Models\AbstractModels\AbstractRecord;

/**
 * Class Subscription
 * @package Paytic\Payments\Models\Subscriptions
 */
class Subscription extends AbstractRecord implements SubscriptionInterface
{
    use SubscriptionTrait;
}
