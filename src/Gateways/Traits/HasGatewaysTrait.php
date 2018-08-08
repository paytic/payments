<?php

namespace ByTIC\Payments\Gateways\Traits;

use ByTIC\Payments\Gateways\Manager;
use ByTIC\Payments\Gateways\Providers\AbstractGateway\Traits\GatewayTrait;
use Omnipay\Common\AbstractGateway;
use Omnipay\Common\GatewayInterface;

/**
 * Class HasGatewaysTrait
 * @package ByTIC\Payments\Traits
 */
trait HasGatewaysTrait
{

    /**
     * @var null|Manager
     */
    protected $gatewaysManager = null;

    /**
     * @var null|GatewayTrait|GatewayInterface
     */
    protected $gateway = null;

    /**
     * @return GatewayTrait|GatewayInterface|null
     */
    public function getGateway()
    {
        if ($this->gateway === null) {
            $this->initGateway();
        }
        return $this->gateway;
    }

    /**
     * @param GatewayTrait|GatewayInterface|null $gateway
     */
    public function setGateway($gateway)
    {
        $this->gateway = $gateway;
    }

    protected function initGateway()
    {
        $gateway = $this->newGateway($this->getGatewayName());
        $this->setGateway($gateway);
    }

    /**
     * @param $name
     * @return null|GatewayTrait|GatewayInterface
     */
    protected function newGateway($name)
    {
        /** @var AbstractGateway $gateway */
        $gateway       = $this->getGatewaysManager()::getCollection()->offsetGet($name);
        $gatewayParams = $this->getGatewayOptions();
        $gateway->initialize($gatewayParams);
        return $gateway;
    }

    /**
     * @return Manager|null
     */
    public function getGatewaysManager()
    {
        if ($this->gatewaysManager == null) {
            $this->initGatewaysManager();
        }

        return $this->gatewaysManager;
    }

    /**
     * @param Manager|null $gatewaysManager
     */
    public function setGatewaysManager($gatewaysManager)
    {
        $this->gatewaysManager = $gatewaysManager;
    }

    protected function initGatewaysManager()
    {
        $this->setGatewaysManager(new Manager());
    }

    /**
     * @return string
     */
    abstract public function getGatewayName();

    /**
     * @return mixed
     */
    abstract protected function getGatewayOptions();
}
