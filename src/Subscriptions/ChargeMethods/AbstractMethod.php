<?php

namespace ByTIC\Payments\Subscriptions\ChargeMethods;

/**
 * Class AbstractMethod
 * @package ByTIC\Payments\Subscriptions\ChargeMethods
 */
abstract class AbstractMethod extends \ByTIC\Models\SmartProperties\Properties\AbstractProperty\Generic
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
