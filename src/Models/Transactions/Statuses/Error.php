<?php

namespace Paytic\Payments\Models\Transactions\Statuses;

/**
 * Class Error
 * @package Paytic\Payments\Models\Transactions\Statuses
 */
class Error extends AbstractStatus
{
    public const NAME = 'error';

    /**
     * @return string
     */
    public function getColorClass()
    {
        return 'danger';
    }
}
