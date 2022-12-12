<?php

declare(strict_types=1);

namespace Paytic\Payments\Tests;

use Nip\Config\Config;
use Nip\Container\Container;
use Nip\Records\Locator\ModelLocator;
use Paytic\Payments\Models\Purchases\Purchases;
use Paytic\Payments\PaymentsServiceProvider;
use Paytic\Payments\Tests\Fixtures\Records\Purchases\PurchasableRecordManager;

/**
 * Class PaymentsServiceProviderTest.
 */
class PaymentsServiceProviderTest extends AbstractTestCase
{
    public function testRegister()
    {
        $container = Container::getInstance();

        $data = [
            'payments' => require PROJECT_BASE_PATH . '/config/payments.php',
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
