<?php
namespace Paytic\Payments\Models\Transactions\Statuses;

/**
 * Class Pending
 * @package Paytic\Payments\Models\Transactions\Statuses
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
