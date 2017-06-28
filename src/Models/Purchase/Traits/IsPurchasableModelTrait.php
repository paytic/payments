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
 * @property string $status_notes
 * @property string $received
 * @property string $created
 *
 * @method string getConfirmURL
 * @method string getIpnURL
 * @method Records getManager
 */
trait IsPurchasableModelTrait
{
    use IsPurchasableTrait {
        getPurchaseParameters as getPurchaseParametersAbstract;
    }

    /**
     * @return RequestInterface
     */
    public function getPurchaseRequest()
    {
        return $this->getPaymentMethod()->getGateway()->purchaseFromModel($this);
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
        if ($billing) {
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
        }

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
        return $this->getManager()->getMessage('confirm.' . $this->getStatus()->getName());
    }
}
