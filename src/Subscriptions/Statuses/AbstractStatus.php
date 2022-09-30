<?php

namespace Paytic\Payments\Subscriptions\Statuses;

use ByTIC\Models\SmartProperties\Properties\Statuses\Generic as GenericStatus;
use Paytic\CommonObjects\Subscription\Status\SubscriptionStatusInterface;
use Paytic\Payments\Models\Subscriptions\Subscription;

/**
 * Class AbstractStatus
 * @package KM42\Register\Models\Races\Entries\Statuses
 *
 * @method Subscription getItem()
 */
abstract class AbstractStatus extends GenericStatus implements SubscriptionStatusInterface
{
}
