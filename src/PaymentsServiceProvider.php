<?php

namespace ByTIC\Payments;

use ByTIC\Payments\Gateways\Manager;
use Nip\Container\ServiceProviders\Providers\AbstractSignatureServiceProvider;
use Nip\Records\Locator\ModelLocator;

/**
 * Class PaymentsServiceProvider
 * @package ByTIC\Payments
 */
class PaymentsServiceProvider extends AbstractSignatureServiceProvider
{
    protected static $purchaseModel = 'purchases';
    protected static $purchaseSessionsModel = 'purchase-sessions';

    /**
     * @inheritdoc
     */
    public function register()
    {
        $this->registerPurchases();
        $this->registerGatewaysManager();
        $this->registerPurchaseSessions();
    }

    protected function registerPurchases()
    {
        $this->getContainer()->singleton('purchases', function () {
            return ModelLocator::get($this::$purchaseModel);
        });
    }

    protected function registerPurchaseSessions()
    {
        $this->getContainer()->singleton('purchase-sessions', function () {
            return ModelLocator::get($this::$purchaseSessionsModel);
        });
    }

    protected function registerGatewaysManager()
    {
        $this->getContainer()->singleton('payments.gateways', function () {
            return new Manager();
        });
    }

    /**
     * @param string $purchaseModel
     */
    public static function setPurchaseModel(string $purchaseModel)
    {
        self::$purchaseModel = $purchaseModel;
    }

    /**
     * @param string $purchaseSessionsModel
     */
    public static function setPurchaseSessionsModel(string $purchaseSessionsModel)
    {
        self::$purchaseSessionsModel = $purchaseSessionsModel;
    }

    /**
     * @inheritdoc
     */
    public function provides()
    {
        return ['purchases', 'purchase-sessions','payments.gateways'];
    }
}
