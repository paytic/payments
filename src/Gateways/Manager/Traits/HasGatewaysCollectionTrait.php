<?php

namespace ByTIC\Payments\Gateways\Manager\Traits;


use ByTIC\Payments\Gateways\GatewaysCollection;
use ByTIC\Payments\Gateways\Providers\AbstractGateway\Traits\GatewayTrait;
use Nip\Container\Container;
use Omnipay\Common\AbstractGateway;

/**
 * Trait HasGatewaysCollectionTrait
 * @package ByTIC\Payments\Gateways\Manager\Traits
 */
trait HasGatewaysCollectionTrait
{
    protected $supportedGateways = null;

    /**
     * Internal factory storage
     *
     * @var GatewaysCollection|GatewayTrait[]
     */
    protected $collection;

    /**
     * @param $name
     * @return AbstractGateway
     */
    public static function gateway($name): AbstractGateway
    {
        return self::instance()->getCollection()->get($name);
    }


    /**
     * @return GatewaysCollection
     */
    public static function getAll(): GatewaysCollection
    {
        return self::instance()->getCollection();
    }

    /**
     * Get the gateway factory
     *
     * Creates a new empty GatewayFactory if none has been set previously.
     *
     * @return GatewaysCollection A GatewayFactory instance
     */
    public function getCollection(): GatewaysCollection
    {
        if (is_null($this->collection)) {
            $this->collection = new GatewaysCollection;
            $this->initCollection();
        }

        return $this->collection;
    }

    protected function initCollection()
    {
        $gatewayNames = self::getSupportedGateways();
        $collection = self::getCollection();
        foreach ($gatewayNames as $gatewayClass) {
            $gateway = $this->getFactory()->create( $gatewayClass);
            $collection->offsetSet($gateway->getName(), $gateway);
        }
    }

    /**
     * Get a list of supported gateways which may be available
     *
     * @return array
     */
    public function getSupportedGateways(): array
    {
        if ($this->supportedGateways === null) {
            $this->supportedGateways = $this->generateSupportedGateways();
        }
        return $this->supportedGateways;
    }

    protected function generateSupportedGateways(): array
    {
        if (!function_exists('config') || !function_exists('app')) {
            return $this->generateSupportedGatewaysGeneric();
        }
        $container = function_exists('app') ? app() : Container::getInstance();
        if (!$container->has('config')) {
            return $this->generateSupportedGatewaysGeneric();
        }
        $config = $container->get('config');

        if ($config->has('payments.gateways')) {
            return $config->get('payments.gateways')->toArray();
        }
        return $this->generateSupportedGatewaysGeneric();
    }

    protected function generateSupportedGatewaysGeneric(): array
    {
        return [
            'Payu',
            'Mobilpay',
            'Euplatesc',
            'Librapay',
            'Romcard',
            'Twispay',
            'Paylike',
            'PlatiOnline'
        ];
    }
}
