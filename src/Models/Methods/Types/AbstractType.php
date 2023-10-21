<?php

namespace Paytic\Payments\Models\Methods\Types;

use ByTIC\Models\SmartProperties\Properties\Types\Generic;
use Paytic\Payments\Models\Methods\PaymentMethod;

/**
 * Class AbstractType
 * @package Paytic\Payments\Models\Methods\Types
 * @method PaymentMethod getItem()
 */
abstract class AbstractType extends Generic
{
    protected $message;

    /**
     * @return bool|string
     */
    public function getEntryDescription()
    {
        return null;
    }

    /**
     * @return mixed
     */
    public function getMessage()
    {
        if (!$this->message) {
            $this->message = $this->getManager()->getMessage('types.' . $this->getName());
        }
        return $this->message;
    }

    public function afterInsert()
    {
    }

    /**
     * @return bool
     */
    public function checkConfirmRedirect()
    {
        return false;
    }
}
