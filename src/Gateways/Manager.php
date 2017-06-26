<?php

namespace ByTIC\Payments\Gateways;

/**
 * Class Payment_Gateways
 */
class Manager
{

    /**
     * Internal factory storage
     *
     * @var GatewayFactory
     */
    private static $factory;

    /**
     * Internal factory storage
     *
     * @var GatewaysCollection
     */
    private static $collection;

    public static function getAll()
    {

    }

    /**
     * Get the gateway factory
     *
     * Creates a new empty GatewayFactory if none has been set previously.
     *
     * @return GatewayFactory A GatewayFactory instance
     */
    public static function getFactory()
    {
        if (is_null(static::$factory)) {
            static::$factory = new GatewayFactory;
        }

        return static::$factory;
    }

    /**
     * Get the gateway factory
     *
     * Creates a new empty GatewayFactory if none has been set previously.
     *
     * @return GatewaysCollection A GatewayFactory instance
     */
    public static function getCollection()
    {
        if (is_null(static::$collection)) {
            static::$collection = new GatewaysCollection;
        }

        return static::$collection;
    }
}
