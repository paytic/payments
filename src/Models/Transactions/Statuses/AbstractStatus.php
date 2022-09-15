<?php

namespace Paytic\Payments\Models\Transactions\Statuses;

use ByTIC\Models\SmartProperties\Properties\Statuses\Generic;
use Nip\Records\Record;
use Paytic\Payments\Models\Purchase\Traits\IsPurchasableModelTrait;

/**
 * Class AbstractStatus
 * @package Galantom\Common\Models\Transactions\Statuses
 *
 * @method Record|IsPurchasableModelTrait getItem()
 */
abstract class AbstractStatus extends Generic
{
    /**
     * @return bool
     */
    public function needsAssessment()
    {
        return true;
    }
}
