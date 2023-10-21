<?php

namespace Paytic\Payments\Tests\Transactions\Models\Traits\HasSource;

use Paytic\Payments\Models\Transactions\Transaction;
use Paytic\Payments\Models\Transactions\Transactions;
use Paytic\Payments\Transactions\SourceTypes\Api;
use Paytic\Payments\Transactions\SourceTypes\Card;
use Paytic\Payments\Transactions\SourceTypes\External;
use Paytic\Payments\Transactions\SourceTypes\TokenCard;
use PHPUnit\Framework\TestCase;
use function PHPUnit\Framework\assertSame;

class HasSourceRecordTraitTest extends TestCase
{
    /**
     * @dataProvider data_getType
     */
    public function testGetType($type, $class)
    {
        $repository = new Transactions();
        $repository->bootTraits();

        $record = new Transaction();
        $record->setManager($repository);
        $record->source_type = $type;

        self::assertSame($type, $record->getSourceType());
        self::assertSame($type, $record->source_type);

        $type = $record->getSourceTypeObject();
        self::assertInstanceOf($class, $type);

        $typeNew = new $class();
        assertSame($typeNew::NAME, $type->getName());
    }

    /**
     * @return array
     */
    public function data_getType()
    {
        return [
            [null, Card::class],
            ['', Card::class],
            ['card', Card::class],
            ['external', External::class],
            ['token_card', TokenCard::class],
            ['api', Api::class],
        ];
    }
}
