<?php

namespace ByTIC\Payments\Tests\Gateways\Providers\AbstractGateway\Traits;

use ByTIC\Payments\Tests\AbstractTest;

/**
 * Class DetectFromHttpRequestTraitTest
 * @package ByTIC\Payments\Tests\Gateways\Providers\AbstractGateway\Traits
 * @deprecated use \Paytic\Payments\Tests\Gateways\Traits\ServerCompletePurchaseResponseTrait;
 */
class DetectFromHttpRequestTraitTest extends \Paytic\Payments\Tests\Gateways\Traits\DetectFromHttpRequestTraitTest
{
    use \Paytic\Payments\Tests\Gateways\Traits\ServerCompletePurchaseResponseTrait;
}
