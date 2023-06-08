<?php

namespace Paytic\Payments\Models\AbstractModels;

use ByTIC\Records\Behaviors\HasForms\HasFormsRecordTrait;
use Nip\Records\Record;

/**
 * Class AbstractRecord
 * @package Paytic\Payments\Models\Subscriptions
 */
abstract class AbstractRecord extends Record
{
    use HasFormsRecordTrait;

    public function getRegistry()
    {
    }
}
