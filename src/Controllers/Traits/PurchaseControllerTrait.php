<?php

namespace Paytic\Payments\Controllers\Traits;

use Paytic\Payments\Controllers\Traits\PurchaseController\PurchaseConfirmActionsTrait;
use Paytic\Payments\Controllers\Traits\PurchaseController\PurchaseIpnActionsTrait;
use Paytic\Payments\Controllers\Traits\PurchaseController\PurchaseRedirectActionsTrait;
use Paytic\Payments\Gateways\Manager as GatewaysManager;
use Paytic\Payments\Models\Purchase\Traits\IsPurchasableModelTrait;
use Nip\Records\AbstractModels\Record;
use Nip\Records\RecordManager;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class PurchaseControllerTrait
 * @package Paytic\Payments\Payments\Controllers\Traits
 *
 * @method IsPurchasableModelTrait checkItem
 */
trait PurchaseControllerTrait
{
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

    /**
     * @return Request
     */
    abstract protected function getRequest();

    abstract protected function dispatchAccessDeniedResponse();
}
