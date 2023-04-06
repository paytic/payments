<?php

namespace Paytic\Payments\Purchases\Actions;

use Exception;
use Paytic\Payments\Models\BillingRecord\Traits\RecordTrait as BillingRecordTrait;

/**
 *
 */
class CreatePurchaseParametersCardAction
{
    protected $purchase;

    public static function forPurchase($purchase)
    {
        $action = new self();
        $action->purchase = $purchase;
        return $action;
    }

    public function handle()
    {
        /** @var BillingRecordTrait $billing */
        $billing = $this->purchase->getPurchaseBillingRecord();

        $this->guardIsObject($billing);
        $this->guardIsBillingRecord($billing);

        $params = [];
        $params['firstName'] = $billing->getFirstName();
        $params['lastName'] = $billing->getLastName();
        $params['email'] = $billing->getEmail();
        $params['phone'] = $billing->getPurchasePhone();
        $params['address1'] = $billing->getPurchaseAddress();
        $params['city'] = $billing->getPurchaseCity();
        $params['country'] = $billing->getPurchaseCountry();

        return $params;
    }

    /**
     * @param BillingRecordTrait $billing
     * @return void
     */
    protected function guardIsObject($billing): void
    {
        if (is_object($billing)) {
            return;
        }
        $this->throwError('PurchaseBillingRecord is not an object');
    }

    /**
     * @return mixed
     */
    protected function throwError($message)
    {
        throw new Exception(
            sprintf(
                $message . ' for [%s]',
                $this->purchase->getClassName()
            )
        );
    }

    /**
     * @param BillingRecordTrait $billing
     * @return void
     */
    protected function guardIsBillingRecord($billing): void
    {
        if (in_array(BillingRecordTrait::class, class_uses($billing))) {
            return;
        }
        $this->throwError(
            'Billing record must use BillingRecordTrait',
        );
    }


}