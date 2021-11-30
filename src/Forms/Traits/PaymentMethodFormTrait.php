<?php

namespace ByTIC\Payments\Forms\Traits;

use ByTIC\MediaLibrary\HasMedia\HasMediaTrait;
use ByTIC\MediaLibrary\HasMedia\Traits\AddMediaTrait;
use ByTIC\Payments\Gateways\Manager as GatewaysManager;
use ByTIC\Payments\Gateways\Providers\AbstractGateway\Traits\GatewayTrait;
use ByTIC\Payments\Models\Methods\Traits\RecordTrait as PaymentMethod;
use ByTIC\Payments\Models\Methods\Types\CreditCards;
use Nip\Form\Elements\AbstractElement as FormElementAbstract;
use Nip_Form_Element_Select as FormSelect;

/**
 * Class PaymentMethodFormTrait
 * @package ByTIC\Payments\Forms\Traits
 *
 * @method addInput($name, $label = false, $type = 'input', $isRequired = false)
 * @method addHidden($name, $label = false, $type = 'input', $isRequired = false)
 * @method addSelect($name, $label = false, $type = 'input', $isRequired = false)
 * @method addDisplayGroup(array $elements, $name)
 */
trait PaymentMethodFormTrait
{
    use AbstractFormTrait;

    /**
     * @var null|GatewaysManager
     */
    protected $paymentGatewaysManager = null;

    /**
     * @var null|GatewayTrait[]
     */
    protected $paymentGatewaysItems = null;

    /**
     * @var null|array
     */
    protected $paymentGatewaysNames = null;

    /**
     * @param $request
     */
    public function getDataFromRequest($request)
    {
        /** @noinspection PhpUndefinedClassInspection */
        parent::getDataFromRequest($request);

        $this->getDataFromRequestPaymentGateways($request);
    }

    /**
     * @param $request
     */
    protected function getDataFromRequestPaymentGateways($request)
    {
        $gateways = $this->getPaymentGatewaysItems();
        foreach ($gateways as $gateway) {
            $gateway->getOptionsForm()->getDataFromRequest($request);
        }
    }

    /**
     * @return GatewayTrait[]
     */
    public function getPaymentGatewaysItems()
    {
        $this->checkPaymentGatewaysValues();

        return $this->paymentGatewaysItems;
    }

    /**
     * @param null $paymentGatewaysItems
     */
    public function setPaymentGatewaysItems($paymentGatewaysItems)
    {
        $this->paymentGatewaysItems = $paymentGatewaysItems;
    }

    protected function checkPaymentGatewaysValues()
    {
        if ($this->paymentGatewaysItems == null) {
            $this->paymentGatewaysItems = $this->getPaymentGatewaysManager()::getAll();
            $this->paymentGatewaysNames = $this->paymentGatewaysItems->keys();
        }
    }

    /**
     * @return GatewaysManager
     */
    public function getPaymentGatewaysManager()
    {
        if ($this->paymentGatewaysManager == null) {
            $this->initPaymentGatewaysManager();
        }

        return $this->paymentGatewaysManager;
    }

    /**
     * @param null $paymentGatewaysManager
     */
    public function setPaymentGatewaysManager($paymentGatewaysManager)
    {
        $this->paymentGatewaysManager = $paymentGatewaysManager;
    }

    protected function initPaymentGatewaysManager()
    {
        $this->setPaymentGatewaysManager($this->newPaymentGatewaysManager());
    }

    /**
     * @return GatewaysManager
     */
    protected function newPaymentGatewaysManager()
    {
        return new GatewaysManager();
    }

    public function processValidation()
    {
        /** @noinspection PhpUndefinedClassInspection */
        parent::processValidation();

        $this->processValidationPaymentGateways();
    }

    protected function processValidationPaymentGateways()
    {
        $gateways = $this->getPaymentGatewaysItems();
        foreach ($gateways as $gateway) {
            $gateway->getOptionsForm()->processValidation();
        }
    }

    public function process()
    {
        $this->saveToModel();
        $this->getModel()->save();

        $this->processFormPaymentGateways();
    }

    public function saveToModel()
    {
        /** @noinspection PhpUndefinedClassInspection */
        parent::saveToModel();

        $this->saveToModelTypeMethod();
        $this->saveToModelPaymentGateways();
    }

    protected function saveToModelTypeMethod()
    {
        /** @var FormSelect $typeInput */
        $typeInput = $this->getElement('type');
        $type = $typeInput->getValue();

        if (in_array($type, $this->getPaymentGatewaysNames())) {
            $this->getModel()->type = 'credit-cards';
            $this->getModel()->setOption('payment_gateway', $type);
        }
    }

    /**
     * @param $name
     * @return FormElementAbstract
     */
    abstract public function getElement($name);

    /**
     * @return array|null
     */
    public function getPaymentGatewaysNames()
    {
        $this->checkPaymentGatewaysValues();

        return $this->paymentGatewaysNames;
    }

    /**
     * @return PaymentMethod|HasMediaTrait|AddMediaTrait
     */
    abstract public function getModel();

    protected function saveToModelPaymentGateways()
    {
        $gateways = $this->getPaymentGatewaysItems();
        foreach ($gateways as $gateway) {
            $gateway->getOptionsForm()->saveToModel();
        }
    }

    protected function processFormPaymentGateways()
    {
        $gateways = $this->getPaymentGatewaysItems();
        foreach ($gateways as $gateway) {
            $gateway->getOptionsForm()->process();
        }
    }

    protected function initNameElements()
    {
        $this->addInput('internal_name', translator()->trans('internal_name'), true);
        $this->addInput('name', translator()->trans('name'), true);

        $this->addDisplayGroup(['internal_name', 'name'], 'Details');
    }

    protected function initTypeElement()
    {
        if ($this->getModel()->getPurchasesCount() > 0) {
            $this->addHidden('type', translator()->trans('type'), true);
            $this->addInput('typeText', translator()->trans('type'), false);
            $this->getElement('typeText')->setAttrib('readonly', 'readonly');
        } else {
            $this->initTypeSelect();
        }

        $this->getElement('type')->setId('payment_type');
    }

    protected function initTypeSelect()
    {
        $this->addSelect('type', translator()->trans('type'), true);
        $types = $this->getModel()->getManager()->getTypes();
        foreach ($types as $type) {
            $this->getElement('type')
                ->addOption($type->getName(), $type->getLabel());
        }
        $this->appendPaymentGatewaysOptgroupOption();
    }

    protected function appendPaymentGatewaysOptgroupOption()
    {
        $gateways = $this->getPaymentGatewaysItems();
        /** @var FormSelect $typeInput */
        $typeInput = $this->getElement('type');
        foreach ($gateways as $name => $gateway) {
            $typeInput->appendOptgroupOption(
                $this->getPaymentGatewaysManager()->getLabel('title'),
                $gateway->getName(),
                $gateway->getLabel()
            );
        }
    }

    protected function parseTypeForPaymentGateway()
    {
        $model = $this->getModel();
        if ($model->getType() instanceof CreditCards && $model->getOption('payment_gateway')) {
            $this->getElement('type')->setValue($this->getModel()->getOption('payment_gateway'));
        }
    }

    protected function initPaymentGatewaysOptionsForm()
    {
        $gateways = $this->getPaymentGatewaysItems();

        foreach ($gateways as $name => $gateway) {
            $gateway->getOptionsForm()->setForm($this)->init();
        }
    }

    protected function getDataFromModelPaymentGateways()
    {
        $gateways = $this->getPaymentGatewaysItems();
        foreach ($gateways as $gateway) {
            $gateway->getOptionsForm()->getDataFromModel();
        }
    }
}
