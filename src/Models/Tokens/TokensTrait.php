<?php

namespace Paytic\Payments\Models\Tokens;

use Exception;
use Nip\Config\Config;
use Nip\Records\AbstractModels\Record;
use Paytic\Omnipay\Common\Models\TokenInterface;
use Paytic\Payments\Models\AbstractModels\HasCustomer\HasCustomerRepository;
use Paytic\Payments\Models\AbstractModels\HasDatabase\HasDatabaseConnectionTrait;
use Paytic\Payments\Models\AbstractModels\HasPaymentMethod\HasPaymentMethodRepository;
use Paytic\Payments\Utility\PaymentsModels;

/**
 * Trait TokensTrait
 * @package Paytic\Payments\Models\Tokens
 *
 * @method TokenTrait|Token getNew
 */
trait TokensTrait
{
    use HasCustomerRepository;
    use HasDatabaseConnectionTrait;
    use HasPaymentMethodRepository;

    /**
     * @param $method
     * @param TokenInterface $token
     * @return TokenTrait|Token
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
        $this->initRelationsCommon();
    }

    protected function initRelationsCommon()
    {
        $this->initRelationsTransactions();
        $this->initRelationsPaymentMethod();
        $this->initRelationsCustomer();
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
        return config('payments.tables.tokens', Tokens::TABLE);
    }

    /**
     * @return mixed|Config
     * @throws Exception
     */
    protected function generateController()
    {
        return Tokens::CONTROLLER;
    }
}
