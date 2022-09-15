<?php

namespace Paytic\Payments\Tests\Gateways\Providers\AbstractGateway\Traits;

use Paytic\Payments\Tests\AbstractTest;
use Paytic\Payments\Tests\Gateways\Traits\ServerCompletePurchaseResponseTrait;

/**
 * Class DetectFromHttpRequestTraitTest
 * @package Paytic\Payments\Tests\Gateways\Providers\AbstractGateway\Traits
 * @deprecated use \Paytic\Payments\Tests\Gateways\Traits\ServerCompletePurchaseResponseTrait;
 */
class DetectFromHttpRequestTraitTest extends \Paytic\Payments\Tests\Gateways\Traits\DetectFromHttpRequestTraitTest
{
    use ServerCompletePurchaseResponseTrait;
}
