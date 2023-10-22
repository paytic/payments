<?php

namespace Paytic\Payments\Transactions\SourceTypes;

/**
 * Class Online
 * @package Paytic\Payments\Models\Methods\Types
 */
class Card extends AbstractType
{
    public const NAME = 'card';

    public function getColorClass()
    {
        return 'success';
    }
}
