<?php

namespace Paytic\Payments\Models\Locations;

use Exception;
use Nip\Config\Config;
use Paytic\Payments\Legacy\Models\AbstractModels\HasPaymentMethod\HasPaymentMethodRepository;
use Paytic\Payments\Models\AbstractModels\HasCustomer\HasCustomerRepository;
use Paytic\Payments\Utility\PaymentsModels;

/**
 * Trait LocationsTrait
 * @package Paytic\Payments\Models\Locations
 *
 * @method LocationTrait|Location getNew
 */
trait LocationsTrait
{
    use HasCustomerRepository;
    use HasPaymentMethodRepository;

    protected function initRelations()
    {
        parent::initRelations();
        $this->initRelationsCommon();
    }

    protected function initRelationsCommon()
    {
    }

    protected function initRelationsTransactions()
    {
        $this->hasMany('Transactions', ['class' => get_class(PaymentsModels::transactions()), 'fk' => 'id_token']);
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
        return config('payments.tables.locations', Locations::TABLE);
    }

    /**
     * @return mixed|Config
     * @throws Exception
     */
    protected function generateController()
    {
        return Locations::CONTROLLER;
    }
}
