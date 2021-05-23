<?php

namespace ByTIC\Payments\Models\Tokens;

use ByTIC\Payments\Utility\PaymentsModels;

/**
 * Trait TokensTrait
 * @package ByTIC\Payments\Models\Tokens
 *
 * @method TokenTrait getNew
 */
trait TokensTrait
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
        return config('payments.tables.purchases_sessions', Tokens::TABLE);
    }
}
