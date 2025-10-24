<?php

namespace Paytic\Payments\MethodLinks\Models;

use Exception;
use Nip\Config\Config;
use Paytic\Payments\Models\AbstractModels\AbstractRecordManager;
use Paytic\Payments\Models\AbstractModels\HasDatabase\HasDatabaseConnectionTrait;
use Paytic\Payments\Models\AbstractModels\HasPaymentMethod\HasPaymentMethodRepository;
use Paytic\Payments\Models\AbstractModels\HasTenant\HasTenantRepository;
use Paytic\Payments\Utility\PaymentsModels;

/**
 * Class PaymentMethodLinks
 * @package Paytic\Payments\MethodLinks\Models
 */
class PaymentMethodLinks extends AbstractRecordManager
{
    use HasDatabaseConnectionTrait;
    use HasPaymentMethodRepository, HasTenantRepository;

    public const TABLE = 'payments-methods-links';

    public function initRelations(): void
    {
        parent::initRelations();
        $this->initRelationsPayments();
    }

    protected function initRelationsPayments(): void
    {
        $this->initRelationsPaymentMethod();
        $this->initRelationsPaymentsTenant();
    }

    /**
     * @return mixed|Config
     * @throws Exception
     */
    protected function generateTable()
    {
        return config('payments.tables.' . PaymentsModels::METHOD_LINKS, PaymentMethodLinks::TABLE);
    }
}
