<?php

namespace ByTIC\Payments\Gateways\Providers\AbstractGateway\Message\Traits;

use ByTIC\Models\SmartProperties\RecordsTraits\HasStatus\RecordTrait;
use Paytic\Payments\Models\Purchase\Traits\IsPurchasableModelTrait;
use Paytic\Payments\Models\Transactions\Statuses\Active;
use Paytic\Payments\Models\Transactions\Statuses\Canceled;
use Paytic\Payments\Models\Transactions\Statuses\Error;
use Paytic\Payments\Models\Transactions\Statuses\Pending;
use Nip\Records\Record;

/**
 * Class HasView
 * @package Paytic\Payments\Gateways\Providers\AbstractGateway\Message\Traits
 * @deprecated use \Paytic\Payments\Gateways\Providers\AbstractGateway\Message\Traits\HasModelProcessedResponse;
 */
trait HasModelProcessedResponse
{
    use \Paytic\Payments\Gateways\Providers\AbstractGateway\Message\Traits\HasModelProcessedResponse;

}
