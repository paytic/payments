<?php

namespace ByTIC\Payments\Models\Transactions\Statuses;

/**
 * Class Error
 * @package ByTIC\Payments\Models\Transactions\Statuses
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
