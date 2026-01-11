<?php

namespace Paytic\Payments\Models\Purchase\Traits;

use Exception;
use Nip\Records\AbstractModels\RecordManager;
use Nip\Records\Collections\Associated;
use Omnipay\Common\Message\RequestInterface;
use Paytic\Payments\Gateways\Providers\AbstractGateway\Traits\GatewayTrait;
use Paytic\Payments\Models\BillingRecord\Traits\RecordTrait as BillingRecord;
use Paytic\Payments\Models\Subscriptions\Subscription;
use Paytic\Payments\Models\Transactions\Transaction;
use Paytic\Payments\PaymentMethods\ModelsRelated\HasPaymentMethod\HasPaymentMethodRecordTrait;
use Paytic\Payments\Purchases\Actions\CreatePurchaseParametersCardAction;
use Paytic\Payments\PurchaseSessions\Models\PurchaseSessionTrait;
use Paytic\Payments\Subscriptions\SubscriptionBuilder;

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
 * @method Transaction getPaymentTransaction()
 * @method PurchaseSessionTrait[]|Associated getPurchasesSessions()
 */
trait IsPurchasableModelTrait
{
    use IsPurchasableTrait;
    use HasPaymentMethodRecordTrait;

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
        return $this->getPaymentMethod()?->getGateway();
    }

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
        return CreatePurchaseParametersCardAction::forPurchase($this)->handle();
    }

    /**
     * @return BillingRecord|null
     */
    public function getPurchaseBillingRecord()
    {
        return null;
    }

    public function isSubscription(): bool
    {
        return is_object($this->getSubscription());
    }

    /**
     * @return Subscription|null
     */
    public function getSubscription()
    {
        $transaction = $this->getPaymentTransaction();
        if ($transaction instanceof Transaction) {
            return $transaction->getSubscription();
        }
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
