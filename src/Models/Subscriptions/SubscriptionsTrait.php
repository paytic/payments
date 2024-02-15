<?php

namespace Paytic\Payments\Models\Subscriptions;

use ByTIC\Models\SmartProperties\Properties\Types\Generic as GenericType;
use ByTIC\Models\SmartProperties\RecordsTraits\HasStatus\RecordsTrait;
use Exception;
use Nip\Config\Config;
use Nip\Records\Collections\Collection;
use Paytic\Payments\Models\AbstractModels\HasCustomer\HasCustomerRepository;
use Paytic\Payments\Models\AbstractModels\HasPaymentMethod\HasPaymentMethodRepository;
use Paytic\Payments\Models\AbstractModels\HasToken\HasTokenRepository;
use Paytic\Payments\Models\Subscriptions\Filters\FilterManager;
use Paytic\Payments\Subscriptions\ChargeMethods\Internal;
use Paytic\Payments\Subscriptions\Statuses\Pending;
use Paytic\Payments\Utility\PaymentsModels;

/**
 * Trait SubscriptionsTrait
 * @package Paytic\Payments\Models\Subscriptions
 *
 * @method SubscriptionTrait|Subscription getNew
 */
trait SubscriptionsTrait
{
    use HasCustomerRepository;
    use HasTokenRepository;
    use HasPaymentMethodRepository;
    use Behaviours\HasTransactions\HasTransactionsRepository;
    use RecordsTrait;

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

    protected function initRelationsPayments(): void
    {
        $this->initRelationsTransactions();
        $this->initRelationsLastTransaction();
        $this->initRelationsPaymentMethod();
        $this->initRelationsToken();
        $this->initRelationsTokens();
        $this->initRelationsCustomer();
    }


    protected function initRelationsTokens(): void
    {
        $this->hasMany('Tokens', ['class' => get_class(PaymentsModels::tokens())]);
    }

    protected function registerSmartProperties(): void
    {
        $this->registerSmartProperty('charge_method', 'ChargeMethods');
        $this->registerSmartPropertyStatus();
    }

    /**
     * @return string
     */
    public function getStatusItemsRootNamespace()
    {
        return 'Paytic\Payments\Subscriptions\Statuses\\';
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

    public function getDefaultStatus(): string
    {
        return Pending::NAME;
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
        return 'Paytic\Payments\Subscriptions\ChargeMethods\\';
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
     * @return mixed|Config
     * @throws Exception
     */
    protected function generateTable()
    {
        return config('payments.tables.subscriptions', Subscriptions::TABLE);
    }

    public function generatePrimaryFK(): string
    {
        return 'id_subscription';
    }

    /**
     * @return mixed|Config
     * @throws Exception
     */
    protected function generateController()
    {
        return Subscriptions::CONTROLLER;
    }

    /**
     * @return string
     */
    public function getFilterManagerClass()
    {
        return FilterManager::class;
    }
}
