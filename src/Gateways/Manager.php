<?php

namespace ByTIC\Payments\Gateways;

use ByTIC\Payments\Gateways\Providers\AbstractGateway\Traits\DetectFromHttpRequestTrait;
use ByTIC\Payments\Gateways\Providers\AbstractGateway\Traits\GatewayTrait;
use Nip\Records\AbstractModels\RecordManager;
use Omnipay\Common\Message\AbstractRequest;
use Omnipay\Common\Message\AbstractResponse;
use Symfony\Component\HttpFoundation\Request as HttpRequest;

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
        $request = self::getRequestFromHttpRequest($modelManager, $callback, $httpRequest);
        if (!is_subclass_of($request, AbstractRequest::class)) {
            return false;
        }

        $response = $request->send();
        if (!is_subclass_of($response, AbstractResponse::class)) {
            return false;
        }
        return $response;
    }


    /**
     * @param RecordManager $modelManager
     * @param string $callback
     * @param null|HttpRequest $httpRequest
     * @return bool|\Omnipay\Common\Message\ResponseInterface
     * @throws \Exception
     */
    public static function getRequestFromHttpRequest($modelManager, $callback = null, $httpRequest = null)
    {
        /** @var DetectFromHttpRequestTrait[] $items */
        $items = self::getAll();

        foreach ($items as $item) {
            $request = $item->detectFromHttpRequestTrait($modelManager, $callback, $httpRequest);
            if (is_subclass_of($request, AbstractRequest::class)) {
                return $request;
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
            'Twispay',
            'Paylike'
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
        return translator()->trans('payment-gateways.labels.' . $type, $params, $language);
    }

    /**
     * @param $name
     * @param array $params
     * @param bool $language
     * @return string
     */
    public function getMessage($name, $params = [], $language = false)
    {
        return translator()->trans('payment-gateways.messages.' . $name, $params, $language);
    }
}
