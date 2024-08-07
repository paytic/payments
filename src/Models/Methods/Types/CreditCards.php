<?php

namespace Paytic\Payments\Models\Methods\Types;

use Nip\Helpers\View\Messages as MessagesHelper;
use Paytic\Payments\Gateways\Traits\HasGatewaysTrait;

/**
 * Class Payment_Method_Type_Credit_Cards
 */
class CreditCards extends AbstractType
{
    protected $aliases = ['credit-cards','credit_cards'];

    use HasGatewaysTrait;

    /**
     * @return bool|string
     */
    public function getEntryDescription()
    {
        if (!$this->getGateway()) {
            return MessagesHelper::error(
                $this->getGatewaysManager()->getMessage('entry-payment.invalid')
            );
        } elseif (!$this->getGateway()->isActive()) {
            return MessagesHelper::error(
                $this->getGatewaysManager()->getMessage('entry-payment.inactive')
            );
        }
        return false;
    }

    /**
     * @return bool
     */
    public function checkConfirmRedirect()
    {
        if ($this->getGateway()) {
            return $this->getGateway()->isActive();
        }
        return false;
    }

    /**
     * @return mixed
     */
    public function getGatewayOptions()
    {
        $name = $this->getGatewayName();
        $methodOptions = $this->getItem()->getOption($name, []);
        foreach ($methodOptions as $key => $value) {
            $methodOptions[$key] = is_string($value) ? html_entity_decode($value) : $value;
        }

        $options['PaymentMethod'] = $this->getItem();
        $options = $options + $methodOptions;

        return $options;
    }

    /**
     * @return string
     */
    public function getGatewayName()
    {
        return $this->getItem()->getOption('payment_gateway');
    }
}
