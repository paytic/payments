<?php

namespace ByTIC\Payments\Controllers\Traits;

use ByTIC\Common\Records\Record;
use ByTIC\FacebookPixel\FacebookPixel;
use ByTIC\Omnipay\Common\Message\Traits\RedirectHtmlTrait;
use ByTIC\Payments\Controllers\Traits\PurchaseController\PurchaseConfirmActionsTrait;
use ByTIC\Payments\Controllers\Traits\PurchaseController\PurchaseIpnActionsTrait;
use ByTIC\Payments\Controllers\Traits\PurchaseController\PurchaseRedirectActionsTrait;
use ByTIC\Payments\Gateways\Manager as GatewaysManager;
use ByTIC\Payments\Models\Purchase\Traits\IsPurchasableModelTrait;
use Nip\Records\RecordManager;
use Nip\Request;

/**
 * Class PurchaseControllerTrait
 * @package ByTIC\Common\Payments\Controllers\Traits
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
