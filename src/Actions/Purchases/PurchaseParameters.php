<?php

namespace Paytic\Payments\Actions\Purchases;

use Paytic\Payments\Models\Purchase\Traits\IsPurchasableTrait;

/**
 * Class PurchaseParameters
 * @package Paytic\Payments\Actions\Purchases
 */
class PurchaseParameters
{
    /**
     * @param IsPurchasableTrait $purchase
     * @return array
     */
    public static function for($purchase): array
    {
        $parameters = [];
        $parameters['amount'] = $purchase->getPurchaseAmount();
        $parameters['currency'] = $purchase->getPurchaseCurrency();

        $parameters['orderId'] = $purchase->id;
        $parameters['orderName'] = $purchase->getPurchaseName();
        $parameters['orderDate'] = $purchase->getPurchaseDate();

        $parameters['transactionId'] = $purchase->id;
        $parameters['description'] = $purchase->getPurchaseName();
        $parameters['lang'] = translator()->getLanguage();

        $parameters['items'] = [
            [
                'name' => $purchase->getPurchaseName(),
                'price' => $purchase->getPurchaseAmount(),
                'description' => $purchase->getPurchaseName(),
                'quantity' => 1,
            ],
        ];

        $parameters['returnUrl'] = $purchase->getConfirmURL();
        $parameters['notifyUrl'] = $purchase->getIpnURL();

        $parameters['card'] = $purchase->getPurchaseParametersCard();
        return $parameters;
    }
}
