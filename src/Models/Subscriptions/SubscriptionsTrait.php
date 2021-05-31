<?php

namespace ByTIC\Payments\Models\Subscriptions;

use ByTIC\Payments\Models\AbstractModels\HasCustomer\HasCustomerRepository;
use ByTIC\Payments\Utility\PaymentsModels;

/**
 * Trait SubscriptionsTrait
 * @package ByTIC\Payments\Models\Subscriptions
 *
 * @method SubscriptionTrait|Subscription getNew
 */
trait SubscriptionsTrait
{
    use HasCustomerRepository;
    use \ByTIC\Models\SmartProperties\RecordsTraits\HasStatus\RecordsTrait;

    protected function initRelations()
    {
        parent::initRelations();
        $this->initRelationsPayments();
    }

    protected function initRelationsPayments()
    {
        $this->initRelationsTransactions();
        $this->initRelationsLastTransaction();
        $this->initRelationsToken();
    }

    protected function initRelationsTransactions()
    {
        $this->hasMany('Transactions', ['class' => get_class(PaymentsModels::transactions())]);
    }

    protected function initRelationsLastTransaction()
    {
        $this->hasOne('LastTransaction', ['class' => get_class(PaymentsModels::transactions())]);
    }

    protected function initRelationsToken()
    {
        $this->hasMany('Token', ['class' => get_class(PaymentsModels::tokens())]);
    }

    /**
     * @return string
     */
    public function getStatusItemsRootNamespace()
    {
        return 'ByTIC\Payments\Subscriptions\Statuses\\';
    }

    /**
     * @return string
     */
    public function getStatusItemsDirectory()
    {
        return dirname(dirname(__DIR__))
            . DIRECTORY_SEPARATOR . 'Subscriptions'
            . DIRECTORY_SEPARATOR . 'Statuses';
    }

    /**
     * @return mixed|\Nip\Config\Config
     * @throws \Exception
     */
    protected function generateTable()
    {
        return config('payments.tables.subscriptions', Subscriptions::TABLE);
    }
}
