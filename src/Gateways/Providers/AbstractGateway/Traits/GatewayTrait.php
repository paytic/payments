<?php

namespace ByTIC\Payments\Gateways\Providers\AbstractGateway\Traits;

use ByTIC\Common\Records\Record;
use ByTIC\Common\Records\Traits\Media\Files\RecordTrait as HasFilesRecord;
use ByTIC\Payments\Gateways\Manager;
use ByTIC\Payments\Models\Methods\Traits\RecordTrait as PaymentMethodRecord;
use ByTIC\Payments\Models\Purchase\Traits\IsPurchasableModelTrait;
use Nip\Utility\Traits\NameWorksTrait;
use Omnipay\Common\Message\RequestInterface;
use Symfony\Component\HttpFoundation\Request as HttpRequest;

/**
 * Class Gateway
 * @package ByTIC\Payments\Gateways\Providers\AbstractGateway
 *
 * @property $parameters \Symfony\Component\HttpFoundation\ParameterBag
 */
trait GatewayTrait
{
    use NameWorksTrait;
    use MagicMessagesTrait;
    use HasFormsTrait;
    /**
     * @var null|string
     */
    protected $name = null;

    /**
     * @var null|string
     */
    protected $label = null;

    /**
     * @var Manager
     */
    protected $manager;

    /**
     * @var PaymentMethodRecord
     */
    protected $paymentMethod;

    // ------------ REQUESTS ------------ //

    /**
     * @param array $parameters
     * @return RequestInterface|null
     */
    public function completePurchase(array $parameters = []): RequestInterface
    {
        $return = $this->createNamespacedRequest('CompletePurchaseRequest', $parameters);
        if ($return) {
            return $return;
        }
        /** @noinspection PhpUndefinedMethodInspection */
        return parent::completePurchase($parameters);
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

    /**
     * @param IsPurchasableModelTrait $record
     * @return RequestInterface
     */
    public function purchaseFromModel($record)
    {
        $parameters = $record->getPurchaseParameters();

        return $this->purchase($parameters);
    }

    /**
     * @return null|string
     */
    public function getName()
    {
        if ($this->name === null) {
            $this->initName();
        }

        return $this->name;
    }

    // ------------ GETTERS & SETTERS ------------ //

    /**
     * @param null $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    public function initName()
    {
        $this->setName($this->generateName());
    }

    /**
     * @return string
     */
    protected function generateName()
    {
        return strtolower($this->getLabel());
    }

    /**
     * @return null|string
     */
    public function getLabel()
    {
        if ($this->label === null) {
            $this->initLabel();
        }

        return $this->label;
    }

    /**
     * @param null|string $label
     */
    public function setLabel($label)
    {
        $this->label = $label;
    }

    public function initLabel()
    {
        $this->setLabel($this->generateLabel());
    }

    /**
     * @return string
     */
    public function generateLabel()
    {
        return $this->getNamespaceParentFolder();
    }

    /**
     * @param $value
     * @return mixed
     */
    public function setSandbox($value)
    {
        $return = $this->setParameter('sandbox', $value);
        $this->setTestMode($this->getSandbox() == 'yes');
        return $return;
    }

    /**
     * @return mixed
     */
    public function getSandbox()
    {
        return $this->getParameter('sandbox');
    }

    /**
     * @return Manager
     */
    public function getManager()
    {
        return $this->manager;
    }

    /**
     * @param Manager $manager
     */
    public function setManager($manager)
    {
        $this->manager = $manager;
    }

    /**
     * @return PaymentMethodRecord|Record|HasFilesRecord
     */
    public function getPaymentMethod()
    {
        return $this->paymentMethod;
    }

    /**
     * @param PaymentMethodRecord $paymentMethod
     */
    public function setPaymentMethod($paymentMethod)
    {
        $this->paymentMethod = $paymentMethod;
    }

    /**
     * @param HttpRequest $httpRequest
     */
    public function setHttpRequest($httpRequest)
    {
        $this->httpRequest = $httpRequest;
    }

    /**
     * @return boolean
     */
    abstract public function isActive();

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
}
