<?php

namespace Paytic\Payments\Subscriptions\Statuses;

/**
 * Class Canceled
 * @package KM42\Register\Models\Races\Entries\Statuses
 */
class Canceled extends AbstractStatus
{
    public const NAME = self::CANCELED;

    public function getColorClass()
    {
        return 'danger';
    }
}
