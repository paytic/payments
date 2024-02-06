<?php

namespace Paytic\Payments\Bundle\Controllers\Frontend;

use ByTIC\Controllers\Behaviors\HasStatus;
use Bytic\SignedUrl\Utility\UrlSigner;
use Paytic\Payments\Models\Subscriptions\Subscription;
use Paytic\Payments\Subscriptions\Actions\Lifecycle\CancelSubscription;
use Paytic\Payments\Subscriptions\Actions\Lifecycle\ReactivateSubscription;
use Paytic\Payments\Subscriptions\Actions\Urls\SubscriptionUrls;
use Paytic\Payments\Subscriptions\Dto\Lifecycle\Triggers;
use Paytic\Payments\Utility\PaymentsModels;

/**
 *
 */
trait SubscriptionsControllerTrait
{
    use AbstractControllerTrait;
    use HasStatus;

    protected function parseRequest()
    {
        parent::parseRequest();

        $url = $this->getRequest()->getUri();

        if (UrlSigner::validate($url) == false) {
            $this->dispatchNotFoundResponse();
        }
    }

    public function manage()
    {
        /** @var Subscription $item */
        $item = $this->getModelFromRequest();
        $transactions = $item->getTransactions();
        $lastTransaction = $item->getLastTransaction() ?? reset($transactions);

        $this->payload()->with([
            'item' => $item,
            'statuses' => $this->getModelManager()->getStatuses(),
            'payment_method' => $item->getPaymentMethod(),
            'payment_token' => $item->getToken(),
            'customer' => $item->getCustomer(),
            'transactions' => $transactions,
            'lastTransaction' => $lastTransaction
        ]);
    }

    public function cancel()
    {
        $subscription = $this->getModelFromRequest();
        CancelSubscription::for($subscription)
            ->setTrigger(Triggers::USER)
            ->handle();

        $url = SubscriptionUrls::for($subscription)->manageUrl();
        return $this->flashRedirect(
            $this->getModelManager()->getMessage('cancelled'),
            $url
        );
    }

    public function reactivate()
    {
        $subscription = $this->getModelFromRequest();
        ReactivateSubscription::for($subscription)
            ->setTrigger(Triggers::USER)
            ->handle();

        $url = SubscriptionUrls::for($subscription)->manageUrl();
        return $this->flashRedirect(
            $this->getModelManager()->getMessage('reactivate'),
            $url
        );
    }
    protected function generateModelName(): string
    {
        return get_class(PaymentsModels::subscriptions());
    }
}
