<?php

namespace ByTIC\Payments\Models\Tokens;

use ByTIC\Payments\Models\AbstractModels\AbstractRecordManager;

/**
 * Class Tokens
 * @package ByTIC\Payments\Models\Tokens
 */
class Tokens extends AbstractRecordManager
{
    public const TABLE = 'payments-tokens';
    public const CONTROLLER = 'payments-tokens';

    use TokensTrait;
}
