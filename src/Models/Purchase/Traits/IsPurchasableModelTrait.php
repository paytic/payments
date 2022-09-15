<?php

namespace Paytic\Payments\Models\Purchase\Traits;

use Paytic\Payments\Gateways\Providers\AbstractGateway\Traits\GatewayTrait;
use Paytic\Payments\Models\BillingRecord\Traits\RecordTrait as BillingRecord;
use Paytic\Payments\Models\BillingRecord\Traits\RecordTrait as BillingRecordTrait;
use Paytic\Payments\Models\Methods\Traits\RecordTrait;
use Paytic\Payments\Models\PurchaseSessions\PurchaseSessionTrait;
use Paytic\Payments\Subscriptions\SubscriptionBuilder;
use Exception;
use Nip\Records\AbstractModels\RecordManager;
use Nip\Records\Collections\Associated;
use Omnipay\Common\Message\RequestInterface;

/**
 * Trait IsPurchasableModelTrait
 * @package Paytic\Payments\Models\Purchase\Traits
 *
 * @property int $id
 * @property string $status
 * @property string $status_notes
 * @property string $received
 * @property string $created
 *
 * @method string getConfirmURL()
 * @method string getIpnURL()
 * @method update()
 * @method string getClassName()
 * @method string getStatus()
 *
 * @method RecordManager getManager()
 * @method PurchaseSessionTrait[]|Associated getPurchasesSessions()
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
     * @return bool|GatewayTrait|null
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
     * @return SubscriptionBuilder
     */
    public function newSubscription()
    {
        return SubscriptionBuilder::fromPurchase($this);
    }

    /**
     * @return mixed
     */
    public function getConfirmStatusTitle()
    {
        return $this->getManager()->getMessage('confirm.' . $this->getStatus()->getName());
    }
}
