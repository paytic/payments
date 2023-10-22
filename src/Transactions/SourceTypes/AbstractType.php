<?php

namespace Paytic\Payments\Transactions\SourceTypes;

use ByTIC\Models\SmartProperties\Properties\AbstractProperty\Generic as GenericProperty;
use Paytic\Payments\Models\Transactions\Transaction;

/**
 * Class AbstractType
 * @method Transaction getItem()
 */
abstract class AbstractType extends GenericProperty
{
    public const BASE_PATH = __DIR__;

    /**
     * @var null|string
     */
    protected $field = 'source_type';

    /**
     * @return string
     */
    protected function getLabelSlug(): string
    {
        return 'source_types';
    }
}
