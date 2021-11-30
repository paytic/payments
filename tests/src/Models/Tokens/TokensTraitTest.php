<?php

namespace ByTIC\Payments\Tests\Models\Tokens;

use ByTIC\Payments\Models\Tokens\Tokens;
use ByTIC\Payments\Tests\AbstractTestCase;

/**
 * Class TransactionsTraitTest
 * @package ByTIC\Payments\Tests\Models\Transactions
 */
class TokensTraitTest extends AbstractTestCase
{
    public function test_relations()
    {
        $this->initUtilityModel('purchases');
        $this->initUtilityModel('transactions');
        $this->initUtilityModel('methods');
        $repository = new Tokens();

        self::assertTrue($repository->hasRelation('Transactions'));
        self::assertTrue($repository->hasRelation('Customer'));
        self::assertTrue($repository->hasRelation('PaymentMethod'));
    }

    public function test_getTable()
    {
        $repository = new Tokens();

        self::assertSame('payments-tokens', $repository->getTable());
    }

    public function test_getController()
    {
        $repository = new Tokens();

        self::assertSame('payments-tokens', $repository->getController());
    }
}
