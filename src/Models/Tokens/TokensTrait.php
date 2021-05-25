<?php

namespace ByTIC\Payments\Models\Tokens;

use ByTIC\Omnipay\Common\Models\TokenInterface;
use ByTIC\Payments\Utility\PaymentsModels;
use Nip\Records\AbstractModels\Record;

/**
 * Trait TokensTrait
 * @package ByTIC\Payments\Models\Tokens
 *
 * @method TokenTrait getNew
 */
trait TokensTrait
{

    public function findOrCreateForMethod($method, TokenInterface $token)
    {
        $findToken = $this->findOneByParams(
            [
                'where' => [
                    ['id_method =?', $method],
                    ['token_id = ?', $token->getId()],
                ]
            ]);

        if ($findToken instanceof Record) {
            return $findToken;
        }
        $token = $this->getNew();
        $token->populateFromPaymentMethod($method);
        $token->populateFromToken($token);
        $token->insert();
        return $token;
    }

    protected function initRelations()
    {
        parent::initRelations();
    }

    protected function initRelationsCommon()
    {
        $this->initRelationsPurchase();
        $this->initRelationsPaymentMethod();
    }

    protected function initRelationsPurchase()
    {
        $this->belongsTo('Purchase', ['class' => get_class(PaymentsModels::purchases())]);
    }

    protected function initRelationsPaymentMethod()
    {
        $this->belongsTo('PaymentMethod', ['class' => get_class(PaymentsModels::methods())]);
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
        return config('payments.tables.tokens', Tokens::TABLE);
    }
}
