<?php

namespace Paytic\Payments\Gateways\Manager\Traits;

use Paytic\Payments\Gateways\GatewayFactory;

/**
 * Trait HasFactoryTrait
 * @package Paytic\Payments\Gateways\Manager\Traits
 */
trait HasFactoryTrait
{
    /**
     * Internal factory storage
     *
     * @var GatewayFactory
     */
    protected $factory;

    /**
     * Get the gateway factory
     *
     * Creates a new empty GatewayFactory if none has been set previously.
     *
     * @return GatewayFactory A GatewayFactory instance
     */
    public static function factory(): GatewayFactory
    {
        return static::instance()->getFactory();
    }

    /**
     * Get the gateway factory
     *
     * Creates a new empty GatewayFactory if none has been set previously.
     *
     * @return GatewayFactory A GatewayFactory instance
     */
    public function getFactory(): GatewayFactory
    {
        if (is_null($this->factory)) {
            $this->setFactory(new GatewayFactory);
        }

        return $this->factory;
    }

    /**
     * @param GatewayFactory $factory
     */
    public function setFactory(GatewayFactory $factory): void
    {
        $this->factory = $factory;
    }
}
