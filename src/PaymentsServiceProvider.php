<?php

namespace ByTIC\Payments;

use ByTIC\Payments\Gateways\Manager;
use ByTIC\Payments\Utility\PaymentsModels;
use Nip\Container\ServiceProviders\Providers\AbstractSignatureServiceProvider;
use Nip\Records\Locator\ModelLocator;

/**
 * Class PaymentsServiceProvider
 * @package ByTIC\Payments
 */
class PaymentsServiceProvider extends AbstractSignatureServiceProvider
{
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
        $this->getContainer()->share('purchases', function () {
            return PaymentsModels::purchases();
        });
    }

    protected function registerPurchaseSessions()
    {
        $this->getContainer()->share('purchase-sessions', function () {
            return PaymentsModels::sessions();
        });
    }

    protected function registerGatewaysManager()
    {
        $this->getContainer()->singleton('payments.gateways', function () {
            return new Manager();
        });
    }

    /**
     * @inheritdoc
     */
    public function provides()
    {
        return ['purchases', 'purchase-sessions','payments.gateways'];
    }
}
