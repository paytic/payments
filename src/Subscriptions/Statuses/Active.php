<?php

namespace Paytic\Payments\Subscriptions\Statuses;

/**
 * Class Active
 * @package KM42\Register\Models\Races\Entries\Statuses
 */
class Active extends AbstractStatus
{
    public const NAME = self::ACTIVE;

    public function getColorClass()
    {
        return 'success';
    }

}
