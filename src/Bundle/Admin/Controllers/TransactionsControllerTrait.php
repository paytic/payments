<?php

namespace Paytic\Payments\Bundle\Admin\Controllers;

use ByTIC\Controllers\Behaviors\HasStatus;
use Paytic\Payments\Models\Transactions\Transaction;
use Paytic\Payments\Transactions\Actions\ChargeWithToken;
use Paytic\Payments\Utility\PaymentsModels;

/**
 * @method Transaction getModelFromRequest($key = false)
 */
trait TransactionsControllerTrait
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
        /** @var Transaction $item */
        $item = $this->initExistingItem();

        $this->payload()->with([
            'item' => $item,
            'statuses' => $this->getModelManager()->getStatuses(),
            'payment_method' => $item->getPaymentMethod(),
            'payment_token' => $item->getToken(),
        ]);
    }

    public function retry()
    {
        $transaction = $this->getModelFromRequest();

        $response = ChargeWithToken::process($transaction);
        var_dump($response);
        exit;
    }

    protected function generateModelName(): string
    {
        return get_class(PaymentsModels::transactions());
    }

    /**
     * @param Transaction $item
     */
    protected function checkItemAccess($item)
    {
//        $method = $this->getRequest()->getMethod();
//        $this->checkAndSetForeignModelInRequest($method);

        $purchase = $item->getPurchase();
        $this->checkAndSetForeignModelInRequest($purchase);

        return parent::checkItemAccess($item);
    }
}
