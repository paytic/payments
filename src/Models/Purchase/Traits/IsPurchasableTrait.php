<?php

namespace ByTIC\Payments\Models\Purchase\Traits;

use ByTIC\Payments\Actions\Purchases\PurchaseParameters;

/**
 * Trait IsPurchasableTrait
 * @package ByTIC\Payments\Models\Purchase\Traits
 */
trait IsPurchasableTrait
{

    /**
     * @return array
     */
    public function getPurchaseParameters()
    {
        return PurchaseParameters::for($this);
    }

    abstract public function getPurchaseAmount();

    /**
     * @return string
     */
    public function getPurchaseCurrency()
    {
        return 'RON';
    }

    /**
     * @return string
     */
    public function getPurchaseName()
    {
        return $this->getName();
    }

    abstract public function getName();

    /**
     * @return string
     */
    public function getPurchaseDate()
    {
        return $this->created;
    }

    /**
     * @return array
     */
    public function getPurchaseParametersCard()
    {
        return null;
    }

    /**
     * @return bool
     */
    public function isMultiItemPurchase()
    {
        return false;
    }
}
