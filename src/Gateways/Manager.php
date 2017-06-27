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

    /**
     * @return GatewaysCollection
     */
    public static function getAll()
    {
        return self::getCollection();
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
            self::initCollection();
        }

        return static::$collection;
    }

    protected static function initCollection()
    {
        $gatewayNames = self::getSupportedGateways();
        foreach ($gatewayNames as $gatewayName) {
            $gateway = self::getFactory()->create($gatewayName);
            self::getCollection()->offsetSet($gateway->getName(), $gateway);
        }
    }

    /**
     * Get a list of supported gateways which may be available
     *
     * @return array
     */
    public static function getSupportedGateways()
    {
        return [
            'Payu',
            'Mobilpay',
            'Euplatesc',
            'Twispay'
        ];
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
}
