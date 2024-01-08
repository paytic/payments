<?php

namespace Paytic\Payments\Subscriptions\Statuses;

/**
 * Class Deactivated
 * @package KM42\Register\Models\Races\Entries\Statuses
 */
class Pastdue extends AbstractStatus
{
    public const NAME = self::PASTDUE;

    public function getColorClass()
    {
        return 'warning';
    }
}
