<?php

namespace ByTIC\Payments\Models\Tokens;

use ByTIC\Common\Records\Records;
use Nip\Utility\Traits\SingletonTrait;

/**
 * Class Tokens
 * @package ByTIC\Payments\Models\Tokens
 */
class Tokens extends Records
{
    public const TABLE = 'payments-tokens';

    use SingletonTrait;
    use TokensTrait;

    public function getRootNamespace()
    {
        return 'ByTIC\Payments\Models\\';
    }
}
