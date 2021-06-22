<?php

namespace ByTIC\Payments\Models\Transactions\Statuses;

/**
 * Class Active
 * @package ByTIC\Payments\Models\Transactions\Statuses
 */
class Active extends AbstractStatus
{
    public const NAME = 'active';

    /**
     * @return string
     */
    public function getColorClass()
    {
        return 'success';
    }
}
