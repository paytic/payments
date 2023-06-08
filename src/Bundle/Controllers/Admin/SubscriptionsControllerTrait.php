<?php

namespace Paytic\Payments\Bundle\Controllers\Admin;

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

    /**
     * {@inheritDoc}
     */
    public function indexPrepareItems($items)
    {
        parent::indexPrepareItems($items);
        $items->loadRelation('PaymentMethod');
        $items->loadRelation('Customer');
    }

    public function view()
    {
        /** @var Subscription $item */
        $item = $this->initExistingItem();

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

    /**
     * @param Subscription $item
     */
    protected function checkItemAccess($item)
    {
//        $method = $this->getRequest()->getMethod();
//        $this->checkAndSetForeignModelInRequest($method);

        $customer = $item->getCustomer();
        $this->checkAndSetForeignModelInRequest($customer);

        return parent::checkItemAccess($item);
    }
}
