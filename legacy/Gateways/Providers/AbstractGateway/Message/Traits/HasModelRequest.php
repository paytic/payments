<?php

namespace ByTIC\Payments\Gateways\Providers\AbstractGateway\Message\Traits;

use Paytic\Payments\Models\Purchase\Traits\IsPurchasableModelTrait;
use Nip\Records\AbstractModels\Record;
use Nip\Records\AbstractModels\RecordManager;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class HasModelRequest
 * @package Paytic\Payments\Payments\Gateways\Providers\AbstractGateway\Message\Traits
 * @deprecated use \Paytic\Payments\Gateways\Providers\AbstractGateway\Message\Traits\HasModelRequest;
 */
trait HasModelRequest
{
    use \Paytic\Payments\Gateways\Providers\AbstractGateway\Message\Traits\HasModelRequest;
}
