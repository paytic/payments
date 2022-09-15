<?php

namespace Paytic\Payments\Tests;

use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use Nip\Records\AbstractModels\RecordManager;
use Nip\Records\Locator\ModelLocator;
use Paytic\Payments\Models\Methods\PaymentMethods;
use Paytic\Payments\Models\Purchases\Purchases;
use Paytic\Payments\Models\Transactions\Transactions;
use Paytic\Payments\Utility\PaymentsModels;

/**
 * Class AbstractTestCase
 * @package Paytic\Payments\Tests
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
