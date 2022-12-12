<?php

declare(strict_types=1);

namespace Paytic\Payments\Tests\Models\Tokens;

use Paytic\Payments\Models\Tokens\Tokens;
use Paytic\Payments\Tests\AbstractTestCase;

/**
 * Class TransactionsTraitTest.
 */
class TokensTraitTest extends AbstractTestCase
{
    public function testRelations()
    {
        $this->initUtilityModel('purchases');
        $this->initUtilityModel('transactions');
        $this->initUtilityModel('methods');
        $repository = new Tokens();

        self::assertTrue($repository->hasRelation('Transactions'));
        self::assertTrue($repository->hasRelation('Customer'));
        self::assertTrue($repository->hasRelation('PaymentMethod'));
    }

    public function testGetTable()
    {
        $repository = new Tokens();

        self::assertSame('payments-tokens', $repository->getTable());
    }

    public function testGetController()
    {
        $repository = new Tokens();

        self::assertSame('payments-tokens', $repository->getController());
    }
}
