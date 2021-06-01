<?php
namespace ByTIC\Payments\Models\Transactions\Statuses;

/**
 * Class Pending
 * @package ByTIC\Payments\Models\Transactions\Statuses
 */
class Pending extends AbstractStatus
{
    public const NAME = 'pending';

    /**
     * @return string
     */
    public function getColorClass()
    {
        return 'warning';
    }
}
