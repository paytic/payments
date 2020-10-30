<?php

use ByTIC\Payments\Gateways\Manager as GatewaysManager;
use Nip\Container\Container;

if (!function_exists('payments_gateways')) {
    /**
     * @return GatewaysManager
     */
    function payments_gateways(): GatewaysManager
    {
        $container = function_exists('app') ? app() : Container::getInstance();

        if ($container->has('payments.gateways')) {
            return $container->get('payments.gateways');
        }
        return new GatewaysManager();
    }
}
