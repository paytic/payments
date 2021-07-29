<?php

namespace ByTIC\Payments\Models\Subscriptions;

use ByTIC\Models\SmartProperties\Properties\Types\Generic as GenericType;
use ByTIC\Payments\Models\AbstractModels\HasCustomer\HasCustomerRepository;
use ByTIC\Payments\Models\AbstractModels\HasPaymentMethod\HasPaymentMethodRepository;
use ByTIC\Payments\Models\AbstractModels\HasToken\HasTokenRepository;
use ByTIC\Payments\Subscriptions\ChargeMethods\Internal;
use ByTIC\Payments\Utility\PaymentsModels;
use Nip\Records\Collections\Collection;

/**
 * Trait SubscriptionsTrait
 * @package ByTIC\Payments\Models\Subscriptions
 *
 * @method SubscriptionTrait|Subscription getNew
 */
trait SubscriptionsTrait
{
    use HasCustomerRepository;
    use HasTokenRepository;
    use HasPaymentMethodRepository;
    use \ByTIC\Models\SmartProperties\RecordsTraits\HasStatus\RecordsTrait;

    /**
     * @param int $count
     * @return Collection|Subscription[]
     */
    public function findChargeDue(int $count = 10): Collection
    {
        $query = $this->paramsToQuery();
        $query->where('charge_at IS NOT NULL');
        $query->where('charge_at < NOW()');
        $query->order(['charge_at', 'ASC']);
        $query->limit($count);
        return $this->findByQuery($query);
    }

    /**
     * Get all the types array
     *
     * @return GenericType[]|null
     */
    public function getChargeMethods()
    {
        return $this->getSmartPropertyItems('ChargeMethods');
    }

    /**
     * Get property of a type by name
     *
     * @param string $name Type name
     *
     * @return array
     */
    public function getChargeMethodProperty($name)
    {
        return $this->getSmartPropertyValues('ChargeMethods', $name);
    }

    protected function initRelations()
    {
        parent::initRelations();
        $this->initRelationsPayments();
    }

    protected function initRelationsPayments()
    {
        $this->initRelationsTransactions();
        $this->initRelationsLastTransaction();
        $this->initRelationsPaymentMethod();
        $this->initRelationsToken();
        $this->initRelationsTokens();
        $this->initRelationsCustomer();
    }

    protected function initRelationsTransactions()
    {
        $this->hasMany('Transactions', ['class' => get_class(PaymentsModels::transactions())]);
    }

    protected function initRelationsLastTransaction()
    {
        $this->hasOne('LastTransaction', ['class' => get_class(PaymentsModels::transactions())]);
    }

    protected function initRelationsTokens()
    {
        $this->hasMany('Tokens', ['class' => get_class(PaymentsModels::tokens())]);
    }

    protected function registerSmartProperties()
    {
        $this->registerSmartProperty('charge_method', 'ChargeMethods');
        $this->registerSmartPropertyStatus();
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
     * @return string
     */
    public function getDefaultChargeMethods()
    {
        return Internal::NAME;
    }

    /**
     * @return string
     */
    public function getChargeMethodsItemsRootNamespace()
    {
        return 'ByTIC\Payments\Subscriptions\ChargeMethods\\';
    }

    /**
     * @return string
     */
    public function getChargeMethodsItemsDirectory()
    {
        return dirname(dirname(__DIR__))
            . DIRECTORY_SEPARATOR . 'Subscriptions'
            . DIRECTORY_SEPARATOR . 'ChargeMethods';
    }

    /**
     * @return mixed|\Nip\Config\Config
     * @throws \Exception
     */
    protected function generateTable()
    {
        return config('payments.tables.subscriptions', Subscriptions::TABLE);
    }

    /**
     * @return mixed|\Nip\Config\Config
     * @throws \Exception
     */
    protected function generateController()
    {
        return Subscriptions::CONTROLLER;
    }
}
