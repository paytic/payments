<?php

namespace ByTIC\Payments\Models\Purchase\Traits;

/**
 * Class MethodTrait
 * @package ByTIC\Payments\Traits
 */
trait IsPurchasableTrait
{

    /**
     * @return array
     */
    public function getPurchaseParameters()
    {
        $parameters = [];
        $parameters['amount'] = $this->getPurchaseAmount();
        $parameters['currency'] = $this->getPurchaseCurrency();

        $parameters['orderId'] = $this->id;
        $parameters['orderName'] = $this->getPurchaseName();
        $parameters['orderDate'] = $this->getPurchaseDate();

        $parameters['description'] = $this->getPurchaseName();
        $parameters['lang'] = translator()->getLanguage();

        $parameters['items'] = [
            [
                'name' => $this->getPurchaseName(),
                'price' => $this->getPurchaseAmount(),
                'description' => $this->getPurchaseName(),
                'quantity' => 1,
            ],
        ];

        $parameters['returnUrl'] = $this->getConfirmURL();
        $parameters['notifyUrl'] = $this->getIpnURL();

        $parameters['card'] = $this->getPurchaseParametersCard();

        return $parameters;
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
