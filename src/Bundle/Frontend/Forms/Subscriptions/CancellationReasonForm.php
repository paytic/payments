<?php

namespace Paytic\Payments\Bundle\Frontend\Forms\Subscriptions;

use Nip_Form_Element_CheckboxGroup;
use Nip_Form_Element_Textarea;
use Paytic\Payments\Bundle\Library\Form\FormModel;
use Paytic\Payments\Models\Subscriptions\Subscription;
use Paytic\Payments\Subscriptions\Dto\Cancellation\CancellationReasonEnumInterface;
use Paytic\Payments\Utility\PaymentsModels;

/**
 * @method Subscription getModel()
 */
class CancellationReasonForm extends FormModel
{
    protected CancellationReasonEnumInterface $cancellationReasons;

    public function initialize(): void
    {
        parent::initialize();
        $this->removeClass('form-horizontal');

        $this->initializeReasonElement();
        $this->initializeCommentElement();
        $this->initializeSubmitElement();
    }

    protected function initializeReasonElement(): void
    {
        $this->addCheckboxGroup('reason', PaymentsModels::subscriptions()->getLabel('cancelled.form.reason'));
        /** @var Nip_Form_Element_CheckboxGroup $reasonElement */
        $reasonElement = $this->getElement('reason');
        $reasonElement->getRenderer()->setSeparator('');

        $reasonOptions = $this->cancellationReasons::labels();
        foreach ($reasonOptions as $value => $label) {
            $reasonElement->addOption($value, $label);
        }
    }

    protected function initializeCommentElement(): void
    {
        $this->addTextarea('comment', PaymentsModels::subscriptions()->getLabel('cancelled.form.comment'));
        /** @var Nip_Form_Element_Textarea $commentElement */
        $commentElement = $this->getElement('comment');
        $commentElement->setAttrib('rows', 4);
    }

    protected function initializeSubmitElement(): void
    {
        $this->addButton('submit', PaymentsModels::subscriptions()->getLabel('cancelled.form.submit'));
    }

    public function setCancellationReasons($cancellationReasons): static
    {
        $this->cancellationReasons = $cancellationReasons;
        return $this;
    }

    public function saveToModel()
    {
        $metadata = $this->getModel()->getMetadataObject();

        $reasons = $this->getElement('reason')->getValue();
        $metadata->setCancellationReason($reasons);

        $comment = $this->getElement('comment')->getValue();
        $metadata->setCancellationComment($comment);
    }
}
