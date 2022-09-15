<?php

namespace Paytic\Payments\Tests\Models\Tokens;

use Paytic\Payments\Models\Tokens\Token;
use Paytic\Payments\Tests\AbstractTestCase;

/**
 * Class TokenTraitTest
 * @package Paytic\Payments\Tests\Models\Transactions
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
