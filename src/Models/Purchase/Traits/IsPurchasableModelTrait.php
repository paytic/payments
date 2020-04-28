<?php

namespace ByTIC\Payments\Models\Purchase\Traits;

use ByTIC\Common\Records\Records;
use ByTIC\Payments\Models\BillingRecord\Traits\RecordTrait as BillingRecord;
use ByTIC\Payments\Models\BillingRecord\Traits\RecordTrait as BillingRecordTrait;
use ByTIC\Payments\Models\Methods\Traits\RecordTrait;
use Exception;
use Omnipay\Common\Message\RequestInterface;

/**
 * Class MethodTrait
 * @package ByTIC\Payments\Traits
 *
 * @property int $id
 * @property string $status
 * @property string $status_notes
 * @property string $received
 * @property string $created
 *
 * @method string getConfirmURL()
 * @method string getIpnURL()
 * @method Records getManager()
 * @method update()
 * @method string getClassName()
 * @method string getStatus()
 */
trait IsPurchasableModelTrait
{
    use IsPurchasableTrait;

    /**
     * @return RequestInterface
     */
    public function getPurchaseRequest()
    {
        return $this->getPaymentGateway()->purchaseFromModel($this);
    }

    /**
     * @return bool|\ByTIC\Payments\Gateways\Providers\AbstractGateway\Traits\GatewayTrait|null
     */
    public function getPaymentGateway()
    {
        return $this->getPaymentMethod()->getGateway();
    }

    /**
     * @return RecordTrait
     */
    abstract public function getPaymentMethod();

    /**
     * @param $note
     */
    public function saveGatewayNote($note)
    {
        $this->setGatewayNotes($note);
        $this->update();
    }

    /**
     * @param $note
     */
    public function setGatewayNotes($note)
    {
        $this->status_notes = $note;
    }

    /**
     * @return array
     * @throws Exception
     */
    public function getPurchaseParametersCard()
    {
        $params = null;
        $billing = $this->getPurchaseBillingRecord();
        if (!is_object($billing)) {
            throw new Exception(
                sprintf(
                    'PurchaseBillingRecord is not an object in [%s]',
                    $this->getClassName()
                )
            );
        }
        if (!in_array(BillingRecordTrait::class, class_uses($billing))) {
            throw new Exception(
                sprintf(
                    'Billing record in %s must use BillingRecordTrait %s',
                    $this->getClassName(),
                    BillingRecordTrait::class
                )
            );
        }
        $params = [];
        $params['firstName'] = $billing->getFirstName();
        $params['lastName'] = $billing->getLastName();
        $params['email'] = $billing->getEmail();
        $params['phone'] = $billing->getPurchasePhone();
        $params['city'] = $billing->getPurchaseCity();
        $params['country'] = $billing->getPurchaseCountry();

        return $params;
    }

    /**
     * @return BillingRecord|null
     */
    public function getPurchaseBillingRecord()
    {
        return null;
    }

    /**
     * @return mixed
     */
    public function getConfirmStatusTitle()
    {
        return $this->getManager()->getMessage('confirm.'.$this->getStatus()->getName());
    }
}
