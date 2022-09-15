<?php

namespace Paytic\Payments\Models\Methods\Traits;

use ByTIC\Models\SmartProperties\RecordsTraits\HasTypes\RecordTrait as HasTypesRecordTrait;
use ByTIC\MediaLibrary\HasMedia\HasMediaTrait;
use ByTIC\Records\Behaviors\HasSerializedOptions\HasSerializedOptionsRecordTrait;
use Paytic\Payments\Gateways\Manager;
use Paytic\Payments\Gateways\Providers\AbstractGateway\Traits\GatewayTrait;
use Paytic\Payments\Models\Methods\Types\AbstractType;
use Paytic\Payments\Models\Methods\Types\CreditCards;
use Nip\Records\RecordManager;

/**
 * Class MethodTrait
 * @package Paytic\Payments\Models\Methods\Traits
 *
 * @property string $name
 * @property string $internal_name
 * @property string $description
 * @property string $__notes
 *
 * @method AbstractType|CreditCards getType
 * @method RecordsTrait|RecordManager getManager()
 */
trait RecordTrait
{
    use HasTypesRecordTrait {
        setType as setTypeTrait;
    }
    use HasSerializedOptionsRecordTrait;

    use HasMediaTrait;

    /**
     * @param array $data
     * @return mixed
     */
    public function fill($data = [])
    {
        if (!isset($data['type'])) {
            $data['type'] = 'bank-transfer';
        }

        return parent::fill($data);
    }

    /**
     * @param bool $type
     * @return string
     */
    public function getName($type = false)
    {
        if ($type == 'internal') {
            return $this->getAttributeFromArray('internal_name');
        }
        return $this->getAttributeFromArray('name');
    }

    /**
     * @return bool
     */
    public function checkConfirmRedirect()
    {
        if ($this->getType()->checkConfirmRedirect()) {
            return true;
        }

        return false;
    }

    /**
     * @return bool|string
     */
    public function getEntryDescription()
    {
        $return = $this->getType()->getEntryDescription();
        $return .= $this->getDescription();
        $return .= $this->__notes;

        return $return;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->getAttributeFromArray('description');
    }

    /**
     * @return bool
     */
    public function canDelete()
    {
        if ($this->getPurchasesCount() > 0) {
            return $this->getManager()->getMessage('delete.denied.has-purchases');
        }

        return true;
    }

    /**
     * @return int
     */
    abstract public function getPurchasesCount();

    /**
     * @return bool|GatewayTrait|null
     */
    public function getGateway()
    {
        if ($this->getType() instanceof CreditCards) {
            return $this->getType()->getGateway();
        }

        return false;
    }

    /**
     * @inheritDoc
     */
    public function setType($type = null)
    {
        $paymentGatewaysNames = Manager::getAll()->keys();
        if (in_array($type, $paymentGatewaysNames)) {
            $this->setOption('payment_gateway', $type);
            $type = 'credit-cards';
        }
        return $this->setTypeTrait($type);
    }

    /**
     * @return mixed
     */
    public function getPaymentGatewayOptions()
    {
        $gatewayName = $this->getOption('payment_gateway');

        return $this->getOption($gatewayName);
    }

    /**
     * @param array $options
     * @param null $gatewayName
     * @return mixed
     */
    public function setPaymentGatewayOptions($options, $gatewayName = null)
    {
        $gatewayName = $gatewayName? $gatewayName : $this->getOption('payment_gateway');

        return $this->setOption($gatewayName, $options);
    }
}
