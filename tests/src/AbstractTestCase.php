<?php

namespace ByTIC\Payments\Tests;

use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;

/**
 * Class AbstractTestCase
 * @package ByTIC\Payments\Tests
 */
abstract class AbstractTestCase extends AbstractTest
{
    use MockeryPHPUnitIntegration;
}
