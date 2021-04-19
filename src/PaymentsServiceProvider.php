<?php

namespace ByTIC\Payments;

use ByTIC\Payments\Gateways\Manager;
use ByTIC\Payments\Utility\PaymentsModels;
use Nip\Container\ServiceProviders\Providers\AbstractSignatureServiceProvider;
use Nip\Container\ServiceProviders\Providers\BootableServiceProviderInterface;

/**
 * Class PaymentsServiceProvider
 * @package ByTIC\Payments
 */
class PaymentsServiceProvider extends AbstractSignatureServiceProvider implements BootableServiceProviderInterface
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

    /**
     * @inheritdoc
     */
    public function provides()
    {
        return ['purchases', 'purchase-sessions', 'payments.gateways'];
    }

    public function boot()
    {
        $this->getContainer()->get('migrations.migrator')->path(dirname(__DIR__) . '/migrations/');
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
}
