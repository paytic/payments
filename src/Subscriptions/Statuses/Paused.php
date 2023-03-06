<?php

namespace Paytic\Payments\Subscriptions\Statuses;

/**
 * Class Paused
 * @package KM42\Register\Models\Races\Entries\Statuses
 */
class Paused extends AbstractStatus
{
    public const NAME = self::PAUSED;

    public function getColorClass()
    {
        return 'warning';
    }
}
