<?php

namespace ByTIC\Payments\Tests\Models\Tokens;

use ByTIC\Payments\Models\Tokens\Token;
use ByTIC\Payments\Tests\AbstractTestCase;

/**
 * Class TokenTraitTest
 * @package ByTIC\Payments\Tests\Models\Transactions
 */
class TokenTraitTest extends AbstractTestCase
{
    public function test_getTable()
    {
        $token = new Token();
        $token->token_id = 'MTI2NzgxOvU9tf//XCNC0taaYWK6W0Cj1a+5DhmSx6yIr+DImuz33wtQ+5q8d33qPngNshlSU6qAaZq4/9zbUM3uAPijRuA=';

        self::assertSame('Token MTI2***RuA=', $token->getName());
    }
}
