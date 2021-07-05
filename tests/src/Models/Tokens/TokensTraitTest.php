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
        $this->initUtilityModel('methods');
        $repository = Tokens::instance();

        self::assertTrue($repository->hasRelation('Purchase'));
        self::assertTrue($repository->hasRelation('PaymentMethod'));
    }
}
