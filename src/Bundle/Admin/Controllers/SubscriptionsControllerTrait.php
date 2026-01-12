<?php

namespace Paytic\Payments\Bundle\Admin\Controllers;

use ByTIC\Controllers\Behaviors\HasStatus;
use Paytic\Payments\Models\Subscriptions\Subscription;
use Paytic\Payments\Models\Transactions\Statuses\Active;
use Paytic\Payments\Models\Transactions\Transaction;
use Paytic\Payments\Subscriptions\Actions\Charges\ChargedSuccessfully;
use Paytic\Payments\Subscriptions\Actions\ChargeSubscription;
use Paytic\Payments\Subscriptions\Actions\Lifecycle\CancelSubscription;
use Paytic\Payments\Subscriptions\Actions\Lifecycle\DeactivateSubscription;
use Paytic\Payments\Subscriptions\Actions\Lifecycle\MarkUnpaidSubscription;
use Paytic\Payments\Subscriptions\Actions\Stats\SubscriptionsStatsByStatus;
use Paytic\Payments\Subscriptions\Statuses\Canceled;
use Paytic\Payments\Subscriptions\Statuses\Deactivated;
use Paytic\Payments\Subscriptions\Statuses\Unpaid;
use Paytic\Payments\Utility\PaymentsModels;

/**
 *
 */
trait SubscriptionsControllerTrait
{
    use AbstractControllerTrait;
    use HasStatus {
        changeSmartPropertyValueUpdate as changeSmartPropertyValueUpdateTrait;
    }

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


    public function processTransaction()
    {
        /** @var Subscription $item */
        $subscription = $this->getModelFromRequest();

        /** @var Transaction $item */
        $transaction = PaymentsModels::transactions()->findOne($this->getRequest()->get('id_transaction'));
        if ($transaction->id_subscription != $subscription->id) {
            $this->flashRedirect(
                'Transaction does not belong to subscription',
                $subscription->compileURL('view'),
                'error'
            );
        }
        if (!$transaction->isInStatus(Active::NAME)) {
            $this->flashRedirect(
                'Transaction is not active',
                $subscription->compileURL('view'),
                'error'
            );
        }

        ChargedSuccessfully::handle($subscription, $transaction);
        $this->flashRedirect(
            'Transaction processed',
            $subscription->compileURL('view'),
            'success'
        );
    }

    public function reports()
    {
        $statuses = SubscriptionsStatsByStatus::make()->execute();
        $this->payload()->with(['statuses' => $statuses]);
    }

    public function attemptCharge()
    {
        /** @var Subscription $item */
        $item = $this->initExistingItem();

        $action = new ChargeSubscription($item);
        $action->execute();

        $this->flashRedirect(
            'Attempted charge for subscription ' . $item->id,
            $item->compileURL('view'),
            'success'
        );
    }

    /**
     * @param $definitionName
     * @param Subscription $item
     * @param $value
     * @return void
     */
    protected function changeSmartPropertyValueUpdate($definitionName, $item, $value)
    {
        if ($definitionName === 'status') {
            if ($value === Active::NAME) {
            } elseif ($value === Canceled::NAME) {
                CancelSubscription::for($item)->handle();
                return;
            } elseif ($value == Deactivated::NAME) {
                DeactivateSubscription::for($item)->handle();
                return;
            } elseif ($value == Unpaid::NAME) {
                MarkUnpaidSubscription::for($item)->handle();
                return;
            }
        }
        $this->changeSmartPropertyValueUpdateTrait($definitionName, $item, $value);
    }

    protected function generateModelName(): string
    {
        return PaymentsModels::subscriptionsClass();
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
