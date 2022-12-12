<?php

declare(strict_types=1);

namespace Paytic\Payments\Tests\Models\Tokens;

use Paytic\Payments\Models\Tokens\Token;
use Paytic\Payments\Tests\AbstractTestCase;

/**
 * Class TokenTraitTest.
 */
class TokenTraitTest extends AbstractTestCase
{
    public function testGetTable()
    {
        $token = new Token();
        $token->token_id = 'MTI2NzgxOvU9tf//XCNC0taaYWK6W0Cj1a+5DhmSx6yIr+DImuz33wtQ+5q8d33qPngNshlSU6qAaZq4/9zbUM3uAPijRuA=';

        self::assertSame('Token MTI2***RuA=', $token->getName());
    }
}
