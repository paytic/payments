<?php

namespace ByTIC\Payments\Tests;

use ByTIC\Payments\Models\Purchases\Purchases;
use ByTIC\Payments\PaymentsServiceProvider;
use ByTIC\Payments\Tests\Fixtures\Records\Purchases\PurchasableRecordManager;
use Nip\Config\Config;
use Nip\Container\Container;
use Nip\Records\Locator\ModelLocator;

/**
 * Class PaymentsServiceProviderTest
 * @package ByTIC\Payments\Tests
 */
class PaymentsServiceProviderTest extends AbstractTestCase
{
    public function testRegister()
    {
        $container = Container::getInstance();

        $data = [
            'payments' => require PROJECT_BASE_PATH . '/config/payments.php'
        ];
        $config = new Config($data);
        $container->set('config', $config);

        ModelLocator::set(Purchases::class, new PurchasableRecordManager());

        $provider = new PaymentsServiceProvider();
        $provider->setContainer($container);
        $provider->register();

        $purchases = $provider->getContainer()->get('purchases');
        self::assertInstanceOf(PurchasableRecordManager::class, $purchases);
    }
}
