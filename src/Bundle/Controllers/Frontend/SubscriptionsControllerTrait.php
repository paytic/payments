<?php

namespace Paytic\Payments\Bundle\Controllers\Frontend;

use ByTIC\Controllers\Behaviors\HasStatus;
use Paytic\Payments\Models\Subscriptions\Subscription;
use Paytic\Payments\Utility\PaymentsModels;

/**
 *
 */
trait SubscriptionsControllerTrait
{
    use AbstractControllerTrait;
    use HasStatus;

    public function manage()
    {
        /** @var Subscription $item */
        $item = $this->getModelFromRequest();

        $this->payload()->with([
            'item' => $item,
            'statuses' => $this->getModelManager()->getStatuses(),
            'payment_method' => $item->getPaymentMethod(),
            'payment_token' => $item->getToken(),
            'customer' => $item->getCustomer(),
            'transactions' => $item->getTransactions(),
        ]);
    }

    protected function generateModelName(): string
    {
        return get_class(PaymentsModels::subscriptions());
    }
}
