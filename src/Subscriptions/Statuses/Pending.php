<?php

namespace Paytic\Payments\Subscriptions\Statuses;

/**
 * Class Pending
 * @package KM42\Register\Models\Races\Entries\Statuses
 */
class Pending extends AbstractStatus
{
    public const NAME = self::PENDING;

    public function getColorClass()
    {
        return 'info';
    }
}
