<?php

namespace ByTIC\Payments\Models\Transactions\Statuses;

use ByTIC\Models\SmartProperties\Properties\Statuses\Generic;
use ByTIC\Payments\Models\Purchase\Traits\IsPurchasableModelTrait;
use Nip\Records\Record;

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
