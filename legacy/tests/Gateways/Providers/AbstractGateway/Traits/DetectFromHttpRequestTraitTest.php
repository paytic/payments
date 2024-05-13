<?php

declare(strict_types=1);

namespace Paytic\Payments\Tests\Gateways\Providers\AbstractGateway\Traits;

use Paytic\Payments\Tests\Gateways\Providers\AbstractGateway\Message\ServerCompletePurchaseResponseTrait;

/**
 * Class DetectFromHttpRequestTraitTest.
 *
 * @deprecated use \Paytic\Payments\Tests\Gateways\Traits\ServerCompletePurchaseResponseTrait;
 */
class DetectFromHttpRequestTraitTest extends \Paytic\Payments\Tests\Gateways\Traits\DetectFromHttpRequestTraitTest
{
    use ServerCompletePurchaseResponseTrait;

    protected function getNewResponse()
    {
        // TODO: Implement getNewResponse() method.
    }
}
