<?php

namespace ByTIC\Payments\Models\PurchaseSessions;

use ByTIC\Payments\Gateways\Providers\AbstractGateway\Traits\GatewayTrait as AbstractGateway;

/**
 * Trait PurchaseSessionTrait
 * @package ByTIC\Payments\Models\PurchaseSessions
 *
 * @property string $type
 * @property string $new_status
 * @property string $gateway
 * @property string $post
 * @property string $get
 * @property string $created
 */
trait PurchaseSessionTrait
{
    /**
     * @param AbstractGateway $gateway
     */
    public function populateFromGateway($gateway)
    {
        $this->gateway = $gateway->getName();
    }

    public function populateFromRequest()
    {
        $this->post = base64_encode(gzcompress(serialize($_POST)));
        $this->get = base64_encode(gzcompress(serialize($_GET)));
    }
}
