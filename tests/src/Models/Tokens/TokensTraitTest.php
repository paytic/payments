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
        $repository = Tokens::instance();

        self::assertTrue($repository->hasRelation('Transactions'));
        self::assertTrue($repository->hasRelation('Customer'));
        self::assertTrue($repository->hasRelation('PaymentMethod'));
    }

    public function test_getTable()
    {
        $repository = Tokens::instance();

        self::assertSame('payments-tokens', $repository->getTable());
    }

    public function test_getController()
    {
        $repository = Tokens::instance();

        self::assertSame('payments-tokens', $repository->getController());
    }
}
