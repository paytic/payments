<?php

namespace ByTIC\Payments\Models\Transactions\Statuses;

/**
 * Class Canceled
 * @package ByTIC\Payments\Models\Transactions\Statuses
 */
class Canceled extends AbstractStatus
{
    public const NAME = 'canceled';
    
    public function getColor()
    {
        return '#636363';
    }
}