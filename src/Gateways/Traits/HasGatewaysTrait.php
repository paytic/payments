<?php

namespace Paytic\Payments\Gateways\Traits;

use Exception;
use Paytic\Payments\Gateways\Manager;
use Paytic\Payments\Gateways\Providers\AbstractGateway\Traits\GatewayTrait;
use Omnipay\Common\AbstractGateway;
use Omnipay\Common\GatewayInterface;

/**
 * Class HasGatewaysTrait
 * @package Paytic\Payments\Traits
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
     * @throws Exception
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

    /**
     * @throws Exception
     */
    protected function initGateway()
    {
        $gateway = $this->newGateway($this->getGatewayName());
        $this->setGateway($gateway);
    }

    /**
     * @param $name
     * @return null|GatewayTrait|GatewayInterface
     * @throws Exception
     */
    protected function newGateway($name)
    {
        if (empty($name)) {
            throw new Exception("No name in newGateway for ".get_class($this));
        }

        $gateway = clone $this->getGatewaysManager()::gateway($name);
        if (!($gateway instanceof GatewayInterface)) {
            throw new Exception("Invalid gateway name ['.$name.'] in ".get_class($this));
        }
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
        $this->setGatewaysManager($this->generateGatewaysManager());
    }

    protected function generateGatewaysManager(): Manager
    {
        return payments_gateways();
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
