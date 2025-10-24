<?php

namespace Paytic\Payments\MethodLinks\Actions;

use Bytic\Actions\Action;
use Bytic\Actions\Behaviours\Entities\FindRecords;
use Bytic\Actions\Behaviours\HasSubject\HasSubject;
use Nip\Records\AbstractModels\RecordManager;
use Paytic\Payments\Utility\PaymentsModels;

/**
 *
 */
class FindMethodsForTenant extends Action
{
    use HasSubject;
    use FindRecords;

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