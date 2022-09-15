<?php

namespace Paytic\Payments\Gateways;

use Omnipay\Common\GatewayInterface;
use Omnipay\Common\Http\ClientInterface;
use RuntimeException;
use Symfony\Component\HttpFoundation\Request as HttpRequest;

/**
 * Class GatewayFactory
 * @package Paytic\Payments\Gateways
 */
class GatewayFactory
{

    /**
     * Create a new gateway instance
     *
     * @param string $class Gateway name
     * @param ClientInterface|null $httpClient A Guzzle HTTP Client implementation
     * @param HttpRequest|null $httpRequest A Symfony HTTP Request implementation
     * @throws RuntimeException                 If no such gateway is found
     * @return GatewayInterface                 An object of class $class is created and returned
     */
    public function create($class, ClientInterface $httpClient = null, HttpRequest $httpRequest = null)
    {
        if (!class_exists($class)) {
            $class = self::getGatewayClassName($class);
            if (!class_exists($class)) {
                throw new RuntimeException("Class '$class' not found");
            }
        }

        return new $class($httpClient, $httpRequest);
    }

    /**
     * Resolve a short gateway name to a full namespaced gateway class.
     *
     * Class names beginning with a namespace marker (\) are left intact.
     * Non-namespaced classes are expected to be in the \Omnipay namespace, e.g.:
     *
     *      \Custom\Gateway     => \Custom\Gateway
     *      \Custom_Gateway     => \Custom_Gateway
     *      Stripe              => \Omnipay\Stripe\Gateway
     *      PayPal\Express      => \Omnipay\PayPal\ExpressGateway
     *      PayPal_Express      => \Omnipay\PayPal\ExpressGateway
     *
     * @param  string $shortName The short gateway name
     * @return string  The fully namespaced gateway class name
     */
    public static function getGatewayClassName($shortName)
    {
        if (0 === strpos($shortName, '\\')) {
            return $shortName;
        }

        // replace underscores with namespace marker, PSR-0 style
        $shortName = str_replace('_', '\\', $shortName);
        if (false === strpos($shortName, '\\')) {
            $shortName .= '\\';
        }

        $tries= [
            '\\Paytic\Payments\\' . $shortName . 'Gateway',
            '\\Paytic\Payments\Gateways\Providers\\' . $shortName . 'Gateway',
            '\\Paytic\Payments\\' . $shortName . 'Gateway',
            '\\Paytic\Payments\Gateways\Providers\\' . $shortName . 'Gateway'
        ];
        foreach ($tries as $try) {
            if (class_exists($try)) {
                return $try;
            }
        }
        return '\\Paytic\Payments\Gateways\Providers\\' . $shortName . 'Gateway';
    }
}
