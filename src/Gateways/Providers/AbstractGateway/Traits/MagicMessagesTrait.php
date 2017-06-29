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

    /**
     * @param $class
     * @param array $parameters
     * @return RequestInterface
     */
    abstract protected function createNamespacedRequest($class, array $parameters);
}
