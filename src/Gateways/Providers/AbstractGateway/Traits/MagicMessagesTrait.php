<?php

namespace ByTIC\Payments\Gateways\Providers\AbstractGateway\Traits;

use BadMethodCallException;
use Omnipay\Common\Message\RequestInterface;
use Omnipay\Common\Message\ResponseInterface as MessageResponseInterface;

/**
 * Trait MagicMessagesTrait
 * @package ByTIC\Payments\Gateways\Providers\AbstractGateway\Traits
 *
 * @method MessageResponseInterface authorize(array $options = [])
 * @method MessageResponseInterface completeAuthorize(array $options = [])
 * @method MessageResponseInterface capture(array $options = [])
 * @method MessageResponseInterface refund(array $options = [])
 * @method MessageResponseInterface void(array $options = [])
 * @method MessageResponseInterface createCard(array $options = [])
 * @method MessageResponseInterface updateCard(array $options = [])
 * @method MessageResponseInterface deleteCard(array $options = [])
 */
trait MagicMessagesTrait
{
    protected $requestsMethods = ['purchase', 'completePurchase', 'serverCompletePurchase'];

    /**
     * @param $name
     * @param $arguments
     * @return RequestInterface
     */
    public function __call($name, $arguments)
    {
        if (in_array($name, $this->requestsMethods)) {
            $name = ucfirst($name) . 'Request';
            return $this->createNamespacedRequest($name, $arguments);
        }
        throw new BadMethodCallException("Invalid method $name");
    }

    // ------------ REQUESTS OVERLOADING ------------ //
    /**
     * @param $request
     * @param array $parameters
     * @return null|RequestInterface
     */
    protected function createRequestWithInternalCheck($request, array $parameters = [])
    {
        $return = $this->createNamespacedRequest($request, $parameters);
        if ($return) {
            return $return;
        }
        if (!method_exists($this, $request)) {
            return null;
        }
        /** @noinspection PhpUndefinedMethodInspection */
        /** @noinspection PhpUndefinedClassInspection */
        return parent::{$request}($parameters);
    }

    /**
     * @param $class
     * @param array $parameters
     * @return RequestInterface|null
     */
    protected function createNamespacedRequest($class, array $parameters)
    {
        $class = $this->getRequestClass($class);

        if (class_exists($class)) {
            return $this->createRequest($class, $parameters);
        }

        return null;
    }

    /**
     * @param $class
     * @param array $parameters
     * @return RequestInterface|null
     * @deprecated Bad name
     */
    protected function createNamepacedRequest($class, array $parameters)
    {
        return $this->createNamespacedRequest($class, $parameters);
    }

    /**
     * @param $class
     * @return string
     */
    protected function getRequestClass($class)
    {
        $class = $this->getNamespacePath() . '\Message\\' . $class;

        if (class_exists($class)) {
            return $class;
        }
        return str_replace('ByTIC\Payments', 'ByTIC\Common\Payments', $class);
    }
}
