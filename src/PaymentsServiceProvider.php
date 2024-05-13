<?php

namespace Paytic\Payments;

use ByTIC\PackageBase\BaseBootableServiceProvider;
use Paytic\Payments\Console\Commands\SessionsCleanup;
use Paytic\Payments\Console\Commands\SubscriptionsCharge;
use Paytic\Payments\Gateways\Manager;
use Paytic\Payments\Utility\PackageConfig;
use Paytic\Payments\Utility\PaymentsModels;

/**
 * Class PaymentsServiceProvider
 * @package Paytic\Payments
 */
class PaymentsServiceProvider extends BaseBootableServiceProvider
{
    public const NAME = 'payments';

    public const PURCHASES = 'purchases';
    public const SESSIONS = 'purchase-sessions';
    public const GATEWAYS = 'payments.gateways';

    public const BASE_DIRECTORY = __DIR__;

    /**
     * @inheritdoc
     */
    public function register()
    {
        $this->registerPurchases();
        $this->registerGatewaysManager();
        $this->registerPurchaseSessions();
        $this->registerResources();
    }

    public function boot(): void
    {
        parent::boot();
        PaymentsModels::purchases();
        PaymentsModels::methods();
        PaymentsModels::sessions();
        PaymentsModels::transactions();
        PaymentsModels::subscriptions();
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

    protected function registerResources()
    {
        if (false === $this->getContainer()->has('translator')) {
            return;
        }
        $translator = $this->getContainer()->get('translator');
        $folder = dirname(__DIR__) . '/resources/lang/';
        $languages = $this->getContainer()->get('translation.languages');


        foreach ($languages as $language) {
            $path = $folder . $language;
            if (is_dir($path)) {
                $translator->prependResource('php', $path, $language);
            }
        }
    }

}
