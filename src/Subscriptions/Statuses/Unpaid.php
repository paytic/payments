<?php

namespace Paytic\Payments\Subscriptions\Statuses;

/**
 * Class Deactivated
 * @package KM42\Register\Models\Races\Entries\Statuses
 */
class Unpaid extends AbstractStatus
{
    public const NAME = self::UNPAID;

    public function getColorClass()
    {
        return 'warning';
    }
}
