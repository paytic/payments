<?php

declare(strict_types=1);

namespace Paytic\Payments\Tests;

use Mockery;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use Nip\Records\AbstractModels\RecordManager;
use Nip\Records\Locator\ModelLocator;
use Paytic\Payments\Models\Methods\PaymentMethods;
use Paytic\Payments\Models\Purchases\Purchases;
use Paytic\Payments\Models\Transactions\Transactions;
use Paytic\Payments\Utility\PaymentsModels;

/**
 * Class AbstractTestCase.
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

    /**
     * @return RecordManager|\Nip\Records\RecordManager|null
     */
    protected function initUtilityModel($type, $value = null)
    {
        if ($value instanceof RecordManager) {
            $value = Mockery::mock($value)->shouldAllowMockingProtectedMethods()->makePartial();
        } else {
            $class = $this->generateRepositoryClass($type);
            /** @var \Nip\Records\RecordManager $value */
            $value = Mockery::mock($class)->shouldAllowMockingProtectedMethods()->makePartial();
            $value->setPrimaryKey('id');
            $value->setFields([]);
            $value->setTableStructure(['fields' => []]);
            $value->setModel($value->generateModelClass($class));

            ModelLocator::set($class, $value);
        }
        $value->shouldReceive('performInsert')->andReturnArg(1);
        ModelLocator::set($type, $value);

        return $value;
    }

    /**
     * @return string|void
     */
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
