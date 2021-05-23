<?php

namespace ByTIC\Payments\Models\Transactions;

use ByTIC\Payments\Utility\PaymentsModels;

/**
 * Trait TransactionsTrait
 * @package ByTIC\Payments\Models\Transactions
 *
 * @method TransactionTrait getNew
 */
trait TransactionsTrait
{

    protected function initRelations()
    {
        parent::initRelations();
    }

    protected function initRelationsCommon()
    {
        $this->initRelationsPurchase();
    }

    protected function initRelationsPurchase()
    {
        $this->belongsTo('Purchase', ['class' => get_class(PaymentsModels::purchases())]);
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
     * @return mixed|\Nip\Config\Config
     * @throws \Exception
     */
    protected function generateTable()
    {
        return config('payments.tables.transactions', \ByTIC\Payments\Models\Transactions\Transactions::TABLE);
    }
}
