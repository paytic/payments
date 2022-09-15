<?php

namespace Paytic\Payments\Models\Transactions;

use ByTIC\Models\SmartProperties\RecordsTraits\HasStatus\RecordsTrait;
use Exception;
use Nip\Config\Config;
use Paytic\Payments\Models\AbstractModels\HasPaymentMethod\HasPaymentMethodRepository;
use Paytic\Payments\Models\AbstractModels\HasToken\HasTokenRepository;
use Paytic\Payments\Models\Purchase\Traits\IsPurchasableModelTrait;
use Paytic\Payments\Models\Purchases\Purchase;
use Paytic\Payments\Utility\PaymentsModels;
use Nip\MailModule\Models\EmailsTable\EmailTrait;
use Nip\Records\AbstractModels\Record;
use Nip\Records\EventManager\Events\Event;

/**
 * Trait TransactionsTrait
 * @package Paytic\Payments\Models\Transactions
 *
 * @method TransactionTrait getNew
 */
trait TransactionsTrait
{
    use RecordsTrait;
    use HasTokenRepository;
    use HasPaymentMethodRepository;

    public function bootTransactionsTrait()
    {
        static::creating(function (Event $event) {

            /** @var EmailTrait|\Nip\Records\Record $record */
            $record = $event->getRecord();

            $record->setIf('metadata', '{}', function () use ($record) {
                return count($record->metadata) < 1;
            });
        });
    }

    /**
     * @param Purchase|IsPurchasableModelTrait $purchase
     * @return TransactionTrait
     */
    public function findOrCreateForPurchase($purchase)
    {
        $transaction = $this->findForPurchase($purchase);
        if ($transaction instanceof Record) {
            return $transaction;
        }
        return $this->createForPurchase($purchase);
    }

    /**
     * @param Purchase|IsPurchasableModelTrait $purchase
     * @return TransactionTrait|null
     */
    public function findForPurchase($purchase)
    {
        return $this->findOneByField('id_purchase', $purchase->id);
    }

    /**
     * @return string
     */
    public function getStatusItemsRootNamespace()
    {
        return '\Paytic\Payments\Models\Transactions\Statuses\\';
    }

    /**
     * @return string
     */
    public function getStatusItemsDirectory()
    {
        return __DIR__ . DIRECTORY_SEPARATOR . 'Statuses';
    }

    /**
     * @param Purchase|IsPurchasableModelTrait $purchase
     * @return TransactionTrait
     */
    protected function createForPurchase($purchase)
    {
        $transaction = $this->getNew();
        $transaction->populateFromPayment($purchase);
        $transaction->populateFromGateway($purchase->getPaymentMethod()->getType()->getGateway());
        $transaction->insert();
        return $transaction;
    }

    protected function initRelations()
    {
        parent::initRelations();
        $this->initRelationsCommon();
    }

    protected function initRelationsCommon()
    {
        $this->initRelationsPurchase();
        $this->initRelationsPaymentMethod();
        $this->initRelationsSubscription();
        $this->initRelationsToken();
    }

    protected function initRelationsPurchase()
    {
        $this->belongsTo('Purchase', ['class' => get_class(PaymentsModels::purchases()), 'fk' => 'id_purchase']);
    }

    protected function initRelationsSubscription()
    {
        $this->belongsTo('Subscription', ['class' => get_class(PaymentsModels::subscriptions())]);
    }

    /**
     * @param array $params
     */
    protected function injectParams(&$params = [])
    {
        $params['order'][] = ['created', 'desc'];

        parent::injectParams($params);
    }

    /**
     * @return mixed|Config
     * @throws Exception
     */
    protected function generateTable()
    {
        return config('payments.tables.transactions', Transactions::TABLE);
    }
}
