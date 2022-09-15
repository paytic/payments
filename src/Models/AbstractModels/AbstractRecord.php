<?php

namespace Paytic\Payments\Models\AbstractModels;

use Nip\Records\Record;

/**
 * Class AbstractRecord
 * @package Paytic\Payments\Models\Subscriptions
 */
abstract class AbstractRecord extends Record
{
    public function getRegistry()
    {
    }
}
