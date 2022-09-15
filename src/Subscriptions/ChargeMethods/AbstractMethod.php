<?php

namespace Paytic\Payments\Subscriptions\ChargeMethods;

use ByTIC\Models\SmartProperties\Properties\AbstractProperty\Generic;

/**
 * Class AbstractMethod
 * @package Paytic\Payments\Subscriptions\ChargeMethods
 */
abstract class AbstractMethod extends Generic
{
    public function getColorClass()
    {
        return 'info';
    }

    /**
     * @inheritDoc
     */
    protected function getLabelSlug(): string
    {
        return 'charge_methods';
    }
}
