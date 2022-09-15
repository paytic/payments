<?php

namespace Paytic\Payments\Models\Tokens;

use Paytic\Payments\Models\AbstractModels\AbstractRecordManager;

/**
 * Class Tokens
 * @package Paytic\Payments\Models\Tokens
 */
class Tokens extends AbstractRecordManager
{
    public const TABLE = 'payments-tokens';
    public const CONTROLLER = 'payments-tokens';

    use TokensTrait;
}
