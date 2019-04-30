<?php

namespace ByTIC\Payments\Gateways;

use ByTIC\Payments\Gateways\Providers\AbstractGateway\Traits\GatewayTrait;
use HttpRequest;
use Nip\Records\AbstractModels\RecordManager;
use Omnipay\Common\Message\AbstractRequest;
use Omnipay\Common\Message\AbstractResponse;

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
     * @var GatewaysCollection|GatewayTrait[]
     */
    private static $collection;

    /**
     * @param RecordManager $modelManager
     * @param string $callback
     * @param null|HttpRequest $httpRequest
     * @return bool|\Omnipay\Common\Message\ResponseInterface
     */
    public static function detectItemFromHttpRequest($modelManager, $callback = null, $httpRequest = null)
    {
        $callback = $callback ? $callback : 'completePurchase';
        $items = self::getAll();

        foreach ($items as $item) {
            if ($httpRequest) {
                $item->setHttpRequest($httpRequest);
            }
            if (method_exists($item, $callback)) {
                /** @var AbstractRequest $request */
                $request = $item->$callback(['modelManager' => $modelManager]);
                if ($request) {
                    $response = $request->send();
                    if (is_subclass_of($response, AbstractResponse::class)) {
                        return $response;
                    }
                }
            }
        }

        return false;
    }

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
            'Librapay',
            'Romcard',
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

    /**
     * @param $type
     * @param array $params
     * @param bool $language
     * @return string
     */
    public function getLabel($type, $params = [], $language = false)
    {
        return translator()->translate('payment-gateways.labels.' . $type, $params, $language);
    }

    /**
     * @param $name
     * @param array $params
     * @param bool $language
     * @return string
     */
    public function getMessage($name, $params = [], $language = false)
    {
        return translator()->translate('payment-gateways.messages.' . $name, $params, $language);
    }
}
