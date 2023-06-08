<?php

namespace Paytic\Payments\Bundle\Admin\Forms;

use Paytic\Payments\Utility\PaymentsModels;

/**
 * Class PaymentMethodFormTrait
 * @package Paytic\Payments\Forms\Traits
 *
 * @method addInput($name, $label = false, $type = 'input', $isRequired = false)
 * @method addHidden($name, $label = false, $type = 'input', $isRequired = false)
 * @method addSelect($name, $label = false, $type = 'input', $isRequired = false)
 * @method addDisplayGroup(array $elements, $name)
 */
trait PaymentSubscriptionFormTrait
{

    public function init()
    {
        parent::init();

        $this->addDateinput('start_at', translator()->trans('start_at'), true);
        $this->getElement('start_at')->setAttrib('readonly', 'readonly');

        $this->addDateinput('charge_at', translator()->trans('charge_at'), true);
        $this->getElement('charge_at')->setAttrib('readonly', 'readonly');

        $this->addSelect('update_to_status', translator()->trans('status'), true);
        $statuses = PaymentsModels::subscriptions()->getStatuses();
        foreach ($statuses as $status) {
            $this->update_to_status->addOption($status->getName(), $status->getLabel());
        }

        $this->addButton('save', translator()->trans('submit'));
    }

    public function getDataFromModel()
    {
        parent::getDataFromModel();
        $this->update_to_status->setValue($this->getModel()->status);
    }

    public function process()
    {
        $this->saveToModel();
        if ($this->getModel()->update_to_status && $this->getModel()->update_to_status != $this->getModel()->status) {
            $this->getModel()->updateStatus($this->getModel()->update_to_status);
        } else {
            $this->getModel()->save();
        }
    }
}
