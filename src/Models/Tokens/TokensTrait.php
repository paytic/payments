<?php

namespace ByTIC\Payments\Models\Tokens;

use ByTIC\Omnipay\Common\Models\TokenInterface;
use ByTIC\Payments\Models\AbstractModels\HasCustomer\HasCustomerRepository;
use ByTIC\Payments\Models\AbstractModels\HasPaymentMethod\HasPaymentMethodRepository;
use ByTIC\Payments\Utility\PaymentsModels;
use Nip\Records\AbstractModels\Record;

/**
 * Trait TokensTrait
 * @package ByTIC\Payments\Models\Tokens
 *
 * @method TokenTrait|Token getNew
 */
trait TokensTrait
{
    use HasCustomerRepository;
    use HasPaymentMethodRepository;

    /**
     * @param $method
     * @param TokenInterface $token
     * @return TokenTrait|Record
     */
    public function findOrCreateForMethod($method, TokenInterface $token)
    {
        $findToken = $this->findOneByParams(
            [
                'where' => [
                    ['id_method =?', is_object($method) ? $method->id : $method],
                    ['token_id = ?', $token->getId()],
                ]
            ]
        );

        if ($findToken instanceof Record) {
            return $findToken;
        }

        return $this->createForMethod($method, $token);
    }

    /**
     * @param $method
     * @param TokenInterface $token
     * @return Token|TokenTrait
     */
    protected function createForMethod($method, TokenInterface $token)
    {
        $item = $this->getNew();
        $item->populateFromPaymentMethod($method);
        $item->populateFromGateway($method->getType()->getGateway());
        $item->populateFromToken($token);
        $item->insert();
        return $item;
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
