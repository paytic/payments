<?php

namespace Paytic\Payments\Transactions\SourceTypes;

use ByTIC\Models\SmartProperties\Properties\Types\Generic;
use Paytic\Payments\Models\Transactions\Transaction;

/**
 * Class AbstractType
 * @method Transaction getItem()
 */
abstract class AbstractType extends Generic
{
    public const BASE_PATH = __DIR__;

}
