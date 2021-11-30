<?php

namespace ByTIC\Payments\Tests;

use ByTIC\Payments\Models\Methods\PaymentMethods;
use ByTIC\Payments\Models\Purchases\Purchases;
use ByTIC\Payments\Models\Transactions\Transactions;
use ByTIC\Payments\Utility\PaymentsModels;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use Nip\Records\AbstractModels\RecordManager;
use Nip\Records\Locator\ModelLocator;
use Paytic\Payments\Tests\AbstractTest;

/**
 * Class AbstractTestCase
 * @package ByTIC\Payments\Tests
 */
abstract class AbstractTestCase extends AbstractTest
{
    use MockeryPHPUnitIntegration;

    protected function setUp(): void
    {
        parent::setUp();
        ModelLocator::instance()->getModelRegistry()->setItems([]);
        PaymentsModels::reset();
    }

    protected function initUtilityModel($type, $value = null)
    {
        if ($value instanceof RecordManager) {
            ModelLocator::set($type, $value);
        } else {
            $class = $this->generateRepositoryClass($type);
            $value = new $class();

            ModelLocator::set($class, $value);
            ModelLocator::set($type, $value);
        }
        return $value;
    }

    protected function generateRepositoryClass($type)
    {
        switch ($type) {
            case 'purchases':
                return Purchases::class;
            case 'methods':
                return PaymentMethods::class;
            case 'transactions':
                return Transactions::class;
        }
    }
}
