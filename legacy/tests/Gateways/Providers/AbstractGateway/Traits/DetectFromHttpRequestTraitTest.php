<?php

declare(strict_types=1);

namespace Paytic\Payments\Tests\Gateways\Providers\AbstractGateway\Traits;

use Paytic\Payments\Tests\Gateways\Traits\ServerCompletePurchaseResponseTrait;

/**
 * Class DetectFromHttpRequestTraitTest.
 *
 * @deprecated use \Paytic\Payments\Tests\Gateways\Traits\ServerCompletePurchaseResponseTrait;
 */
class DetectFromHttpRequestTraitTest extends \Paytic\Payments\Tests\Gateways\Traits\DetectFromHttpRequestTraitTest
{
    use ServerCompletePurchaseResponseTrait;
}
