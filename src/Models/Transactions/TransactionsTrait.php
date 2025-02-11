<?php

namespace Paytic\Payments\Models\Transactions;

use ByTIC\Models\SmartProperties\RecordsTraits\HasStatus\RecordsTrait;
use Exception;
use Nip\Config\Config;
use Nip\Records\AbstractModels\Record;
use Nip\Records\EventManager\Events\Event;
use Paytic\Payments\Models\AbstractModels\HasDatabase\HasDatabaseConnectionTrait;
use Paytic\Payments\Models\AbstractModels\HasPaymentMethod\HasPaymentMethodRepository;
use Paytic\Payments\Models\AbstractModels\HasToken\HasTokenRepository;
use Paytic\Payments\Models\Purchase\Traits\IsPurchasableModelTrait;
use Paytic\Payments\Models\Purchases\Purchase;
use Paytic\Payments\Models\Transactions\Statuses\Pending;
use Paytic\Payments\Transactions\Actions\Create\CreateTransactionForPurchase;
use Paytic\Payments\Transactions\Models\Traits\HasSource\HasSourceRecordsTrait;
use Paytic\Payments\Utility\PaymentsModels;

/**
 * Trait TransactionsTrait
 * @package Paytic\Payments\Models\Transactions
 *
 * @method TransactionTrait getNew
 */
trait TransactionsTrait
{
    use RecordsTrait;
    use HasDatabaseConnectionTrait;
    use HasTokenRepository;
    use HasPaymentMethodRepository;
    use HasSourceRecordsTrait;

    public function bootTransactionsTrait()
    {
        static::creating(function (Event $event) {

            /** @var \Nip\Records\Record $record */
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

    public function getDefaultStatus(): string
    {
        return Pending::NAME;
    }

    /**
     * @param Purchase|IsPurchasableModelTrait $purchase
     * @return TransactionTrait
     */
    protected function createForPurchase($purchase)
    {
        return CreateTransactionForPurchase::for($purchase);
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

    protected function initRelationsPurchase(): void
    {
        $this->belongsTo('Purchase', ['class' => get_class(PaymentsModels::purchases()), 'fk' => 'id_purchase']);
    }

    protected function initRelationsSubscription(): void
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

    /**
     * @return mixed|Config
     * @throws Exception
     */
    protected function generateController()
    {
        return Transactions::CONTROLLER;
    }
}
