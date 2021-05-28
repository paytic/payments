<?php

namespace ByTIC\Payments\Models\Subscriptions;

use ByTIC\Omnipay\Common\Models\SubscriptionInterface;
use ByTIC\Payments\Utility\PaymentsModels;
use Nip\Records\AbstractModels\Record;

/**
 * Trait SubscriptionsTrait
 * @package ByTIC\Payments\Models\Subscriptions
 *
 * @method SubscriptionTrait|Subscription getNew
 */
trait SubscriptionsTrait
{

    /**
     * @param $method
     * @param SubscriptionInterface $token
     * @return SubscriptionTrait|Record
     */
    public function findOrCreateForMethod($method, SubscriptionInterface $token)
    {
        $findSubscription = $this->findOneByParams(
            [
                'where' => [
                    ['id_method =?', is_object($method) ? $method->id : $method],
                    ['token_id = ?', $token->getId()],
                ]
            ]);

        if ($findSubscription instanceof Record) {
            return $findSubscription;
        }

        return $this->createForMethod($method, $token);
    }

    /**
     * @param $method
     * @param SubscriptionInterface $token
     * @return Subscription|SubscriptionTrait
     */
    protected function createForMethod($method, SubscriptionInterface $token)
    {
        $item = $this->getNew();
        $item->populateFromPaymentMethod($method);
        $item->populateFromGateway($method->getType()->getGateway());
        $item->populateFromSubscription($token);
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
        return config('payments.tables.tokens', Subscriptions::TABLE);
    }
}
