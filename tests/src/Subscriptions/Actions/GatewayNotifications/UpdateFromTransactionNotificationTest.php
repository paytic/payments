<?php

namespace Paytic\Payments\Tests\Subscriptions\Actions\GatewayNotifications;

use Mockery;
use Mockery\Mock;
use Paytic\CommonObjects\Subscription\Billing\BillingPeriod;
use Paytic\Payments\Models\Subscriptions\Subscription;
use Paytic\Payments\Models\Transactions\Statuses\Active;
use Paytic\Payments\Models\Transactions\Transaction;
use Paytic\Payments\Models\Transactions\Transactions;
use Paytic\Payments\Subscriptions\Actions\GatewayNotifications\OnTransactionNotification;
use Paytic\Payments\Subscriptions\Statuses\Pending;
use Paytic\Payments\Tests\AbstractTestCase;

/**
 *
 */
class UpdateFromTransactionNotificationTest extends AbstractTestCase
{
    public function test_handle_success_on_empty_subscription()
    {
        /** @var OnTransactionNotification|Mock $action */
        list($action, $subscription, $transaction) = $this->generateEmptyMocks();
        $action->shouldReceive('handleNotStarted')->once();

        $action->execute();
    }

    protected function generateEmptyMocks(): array
    {
        $subscription = Mockery::mock(Subscription::class)
            ->shouldAllowMockingProtectedMethods()
            ->makePartial();
        $subscription->bootTraits();

        $transaction = Mockery::mock(Transaction::class)
            ->shouldAllowMockingProtectedMethods()
            ->makePartial();
        $transaction->id = 999;
        $transaction->setManager(new Transactions());

        $action = Mockery::mock(OnTransactionNotification::class)
            ->shouldAllowMockingProtectedMethods()
            ->makePartial();
        $action->__construct($subscription, $transaction);

        return [$action, $subscription, $transaction];
    }

    public function test_handle_success_on_pending_subscription()
    {
        /** @var OnTransactionNotification|Mock $action */
        /** @var Subscription|Mock $subscription */
        list($action, $subscription, $transaction) = $this->generateEmptyMocks();
        $subscription->status = Pending::NAME;
        $subscription->start_at = '2022-05-01';
        $subscription->billing_period = BillingPeriod::MONTHLY;
        $subscription->billing_interval = 1;
        $subscription->shouldReceive('setStatus')->with(\Paytic\Payments\Subscriptions\Statuses\Active::NAME)->once();
        $subscription->shouldReceive('update')->once();

        $transaction->status = Active::NAME;

        $action->execute();

        self::assertSame('2022-06-01 08:00:00', (string)$subscription->getPropertyRaw('charge_at'));
    }


    public function test_handle_success_on_active_subscription()
    {
        /** @var OnTransactionNotification|Mock $action */
        /** @var Subscription|Mock $subscription */
        list($action, $subscription, $transaction) = $this->generateEmptyMocks();
        $subscription->status = Active::NAME;
        $subscription->start_at = '2022-05-01';
        $subscription->billing_period = BillingPeriod::MONTHLY;
        $subscription->billing_interval = 1;
        $subscription->shouldReceive('update')->once();

        $transaction->status = Active::NAME;

        $action->execute();

        self::assertSame('2022-06-01 08:00:00', (string)$subscription->getPropertyRaw('charge_at'));
        self::assertSame(
            '{"transactions":{"processed":[999]}}',
            $subscription->getPropertyRaw('metadata')
        );

        $action->execute();
        self::assertSame('2022-06-01 08:00:00', (string)$subscription->getPropertyRaw('charge_at'));
    }
}
