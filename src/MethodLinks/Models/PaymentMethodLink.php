<?php

namespace Paytic\Payments\MethodLinks\Models;

use Paytic\Payments\Legacy\Models\AbstractModels\HasPaymentMethod\HasPaymentMethodRecord;
use Paytic\Payments\Models\AbstractModels\AbstractRecord;
use Paytic\Payments\Models\AbstractModels\HasTenant\HasTenantRecord;
use Paytic\Payments\Models\Methods\PaymentMethod;

/**
 * Class PaymentMethodLink
 * @package Paytic\Payments\MethodLinks\Models
 *
 * @property int $id
 * @property int $id_method
 * @property string $visible
 * @property string $primary
 * @property string $notes
 *
 * @method PaymentMethod getPaymentMethod()
 */
class PaymentMethodLink extends AbstractRecord
{
    use HasPaymentMethodRecord;
    use HasTenantRecord;

    public function getId()
    {
        return $this->getPaymentMethod()->id;
    }

    public function getName($type = false)
    {
        return $this->getPaymentMethod()->getName($type);
    }

    public function getInternalName()
    {
        return $this->getPaymentMethod()->getInternalName();
    }

    public function getDescription()
    {
        return $this->getPaymentMethod()->getDescription();
    }

    public function getType()
    {
        return $this->getPaymentMethod()->getType();
    }

    public function getVisible(): ?string
    {
        return $this->getPropertyRaw('visible');
    }

    public function isVisible(): ?bool
    {
        return $this->visible === 'yes';
    }

    public function getPrimary(): ?string
    {
        return $this->getPropertyRaw('primary');
    }

    public function isPrimary(): ?bool
    {
        return $this->primary === 'yes';
    }

    public function getNotes(): ?string
    {
        return $this->getPropertyRaw('notes');
    }
}
