<?php

namespace ByTIC\Payments;

use ByTIC\PackageBase\BaseBootableServiceProvider;
use ByTIC\Payments\Console\Commands\SessionsCleanup;
use ByTIC\Payments\Console\Commands\SubscriptionsCharge;
use ByTIC\Payments\Gateways\Manager;
use ByTIC\Payments\Utility\PackageConfig;
use ByTIC\Payments\Utility\PaymentsModels;

/**
 * Class PaymentsServiceProvider
 * @package ByTIC\Payments
 */
class PaymentsServiceProvider extends BaseBootableServiceProvider
{
    public const NAME = 'payments';

    public const PURCHASES = 'purchases';
    public const SESSIONS = 'purchase-sessions';
    public const GATEWAYS = 'payments.gateways';

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
        return [
            self::PURCHASES,
            self::SESSIONS,
            self::GATEWAYS,
        ];
    }

    public function migrations(): ?string
    {
        if (PackageConfig::shouldRunMigrations()) {
            return dirname(__DIR__) . '/migrations/';
        }

        return null;
    }

    protected function registerPurchases()
    {
        $this->getContainer()->share(self::PURCHASES, function () {
            return PaymentsModels::purchases();
        });
    }

    protected function registerPurchaseSessions()
    {
        $this->getContainer()->share(self::SESSIONS, function () {
            return PaymentsModels::sessions();
        });
    }

    protected function registerGatewaysManager()
    {
        $this->getContainer()->share(self::GATEWAYS, function () {
            return new Manager();
        });
    }

    protected function registerCommands()
    {
        $this->commands(
            SessionsCleanup::class,
            SubscriptionsCharge::class
        );
    }
}
