<?php

namespace Paytic\Payments\Controllers\Traits;

use Nip\Controllers\Traits\AbstractControllerTrait;
use Nip\Records\AbstractModels\Record;
use Nip\Records\RecordManager;
use Paytic\Payments\Controllers\Traits\PurchaseController\PurchaseConfirmActionsTrait;
use Paytic\Payments\Controllers\Traits\PurchaseController\PurchaseIpnActionsTrait;
use Paytic\Payments\Controllers\Traits\PurchaseController\PurchaseRedirectActionsTrait;
use Paytic\Payments\Gateways\Manager as GatewaysManager;
use Paytic\Payments\Models\Purchase\Traits\IsPurchasableModelTrait;

/**
 * Class PurchaseControllerTrait
 * @package Paytic\Payments\Payments\Controllers\Traits
 *
 * @method IsPurchasableModelTrait checkItem
 */
trait PurchaseControllerTrait
{
    use AbstractControllerTrait;

    use PurchaseRedirectActionsTrait;
    use PurchaseConfirmActionsTrait;
    use PurchaseIpnActionsTrait;

    /**
     * @return GatewaysManager
     */
    protected function getGatewaysManager()
    {
        return GatewaysManager::instance();
    }

    /**
     * @param bool|array $key
     * @return Record|IsPurchasableModelTrait
     */
    abstract protected function getModelFromRequest($key = false);

    /**
     * @return RecordManager
     */
    abstract protected function getModelManager();

    abstract protected function dispatchAccessDeniedResponse();
}
