<?php

namespace Paytic\Payments\MethodLinks\Actions;

use Bytic\Actions\Action;
use Bytic\Actions\Behaviours\Entities\FindRecords;
use Bytic\Actions\Behaviours\HasSubject\HasSubject;
use Nip\Records\AbstractModels\RecordManager;
use Nip\Records\Collections\Collection;
use Paytic\Payments\Utility\PaymentsModels;

/**
 *
 */
class FindPaymentMethodLinksForTenant extends Action
{
    use HasSubject;
    use FindRecords;

    /**
     * @return Collection
     * @deprecated use the links object directly
     */
    public function fetchMethods(): Collection
    {
        $collection = new Collection();
        $links = $this->fetch();
        $links->populateRelation('PaymentMethod');
        foreach ($links as $link) {
            $method = $link->getPaymentMethod();
            foreach (['visible', 'primary', 'notes'] as $field) {
                $method->{'__' . $field} = $link->$field;
            }

            $collection->add($method);
        }
        return $collection;
    }

    /**
     * @return array
     */
    protected function findParams(): array
    {
        return [
            'where' => [
                ['tenant_id = ?', $this->getSubject()->id],
                ['tenant = ?', $this->getSubject()->getMorphName()],
            ],
        ];
    }

    protected function generateRepository(): RecordManager
    {
        return PaymentsModels::methodLinks();
    }
}