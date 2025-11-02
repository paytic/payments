<?php

namespace Paytic\Payments\MethodLinks\Actions;

use Bytic\Actions\Action;
use Bytic\Actions\Behaviours\Entities\HasRepository;
use Bytic\Actions\Behaviours\HasSubject\HasSubject;
use Nip\Records\AbstractModels\Record;
use Nip\Records\AbstractModels\RecordManager;
use Paytic\Payments\MethodLinks\Models\PaymentMethodLinks;
use Paytic\Payments\Utility\PaymentsModels;

/**
 *
 */
class AddPaymentMethodLinksForTenant extends Action
{
    use HasRepository;
    use HasSubject;

    protected $paymentMethod;

    public static function for(Record $tenant): self
    {
        $action = new self();
        $action->setSubject($tenant);
        return $action;
    }

    public function withPaymentMethod(Record $paymentMethod)
    {
        $this->paymentMethod = $paymentMethod;
        return $this;
    }

    public function handle()
    {
        $link = $this->generateRepository()->getNew();
        $link->id_method = $this->paymentMethod->id;
        $link->tenant = $this->getSubject()->getManager()->getMorphName();
        $link->tenant_id = $this->getSubject()->id;
        $link->visible = true;
        $link->primary = false;
        $link->notes = '';
        $link->save();
    }

    /**
     * @return RecordManager|PaymentMethodLinks
     */
    protected function generateRepository(): PaymentMethodLinks|RecordManager
    {
        return PaymentsModels::methodLinks();
    }
}