<?php

namespace Paytic\Payments\Models\Transactions\Statuses;

/**
 * Class Canceled
 * @package Paytic\Payments\Models\Transactions\Statuses
 */
class Canceled extends AbstractStatus
{
    public const NAME = 'canceled';
    
    public function getColor()
    {
        return '#636363';
    }
}
