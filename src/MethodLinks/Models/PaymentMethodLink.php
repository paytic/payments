<?php

namespace Paytic\Payments\MethodLinks\Models;

use Paytic\Payments\Models\AbstractModels\AbstractRecord;
use Paytic\Payments\Models\AbstractModels\HasPaymentMethod\HasPaymentMethodRecord;
use Paytic\Payments\Models\AbstractModels\HasTenant\HasTenantRecord;
use Paytic\Payments\Models\Methods\PaymentMethod;
use Paytic\Payments\PaymentMethods\Models\PaymentMethodInterface;

/**
 * Class PaymentMethodLink
 * @package Paytic\Payments\MethodLinks\Models
 *
 * @property int $id
 * @property int|string $id_method
 * @property string $visible
 * @property string $primary
 * @property string $notes
 *
 * @method PaymentMethod getPaymentMethod()
 */
class PaymentMethodLink extends AbstractRecord implements PaymentMethodInterface
{
    use HasPaymentMethodRecord;
    use Traits\PaymentMethodDelegate\PaymentMethodDelegateRecordTrait;
    use HasTenantRecord;

//    public function getId()
//    {
//        return $this->getPaymentMethod()->id;
//    }

    public function getPaymentMethodId(): int
    {
        return (int)$this->id_method;
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
