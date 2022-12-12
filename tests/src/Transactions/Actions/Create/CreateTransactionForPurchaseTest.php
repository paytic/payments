<?php

declare(strict_types=1);

namespace Paytic\Payments\Tests\Transactions\Actions\Create;

use Mockery;
use Paytic\Payments\Models\Purchases\Purchase;
use Paytic\Payments\Models\Transactions\Statuses\Pending;
use Paytic\Payments\Models\Transactions\Transaction;
use Paytic\Payments\Tests\AbstractTestCase;
use Paytic\Payments\Transactions\Actions\Create\CreateTransactionForPurchase;

class CreateTransactionForPurchaseTest extends AbstractTestCase
{
    public function testForPurchaseThrowsInvalidMethod()
    {
        $this->initUtilityModel('transactions');
        $this->initUtilityModel('purchases');

        $purchase = new Purchase();
        self::expectExceptionMessage(CreateTransactionForPurchase::EXCEPTION_INVALID_METHOD);
        CreateTransactionForPurchase::for($purchase);
    }

    public function testForPurchaseEmpty()
    {
        $this->initUtilityModel('transactions');

        $purchase = Mockery::mock(Purchase::class)->makePartial();
        $purchase->__construct();
        $purchase->setManager($this->initUtilityModel('purchases'));

        $action = Mockery::mock(CreateTransactionForPurchase::class)->makePartial();
        $action->shouldAllowMockingProtectedMethods();
        $action->shouldReceive('populatePaymentMethod')->once();
        $action->__construct($purchase);

        $transaction = $action->execute();
        self::assertInstanceOf(Transaction::class, $transaction);
        self::assertSame(Pending::NAME, $transaction->status);
    }
}
