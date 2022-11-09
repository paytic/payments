<?php

namespace Paytic\Payments\Bundle\Controllers\Admin;

use Paytic\Payments\Models\Subscriptions\Subscription;
use Paytic\Payments\Utility\PaymentsModels;

trait SubscriptionsControllerTrait
{
    use AbstractControllerTrait;

    public function view()
    {
        /** @var Subscription $item */
        $item = $this->initExistingItem();

        $this->payload()->with([
            'item' => $item,
            'customer' => $item->getCustomer(),
            'transactions' => $item->getTransactions(),
        ]);
    }

    protected function generateModelName(): string
    {
        return get_class(PaymentsModels::subscriptions());
    }
}
