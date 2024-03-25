<?php

use Paytic\Payments\Models\Transactions\Transaction;
use Paytic\Payments\Utility\PaymentsModels;

/** @var Transaction[] $items */
$items = $items ?? $this->transactions;
?>
<table class="table table-striped">
    <thead>
    <tr>
        <th>
            <?= translator()->trans('name'); ?>
        </th>
        <th>
            <?= PaymentsModels::methods()->getLabel('title.singular'); ?>
        </th>
        <th><?= translator()->trans('amount'); ?></th>
        <th><?= translator()->trans('status'); ?></th>
        <th><?= translator()->trans('card'); ?></th>
        <th><?= translator()->trans('date'); ?></th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($items as $item) { ?>
        <?php
        $purchase = $item->getPurchase();
        $paymentMethod = $item->getPaymentMethod();
        $subscription = $item->getSubscription();
        ?>
        <tr>
            <td>
                <?php if ($subscription->isTransactionProcessed($item)) { ?>
                    <span class="text-success" title="Processed">
                        ✅
                    </span>
                <?php } else { ?>
                    <a href="<?= $subscription->compileURL('process_transaction', ['id_transaction' => $item->id]); ?>">
                        <span class="text-danger" title="Not Processed">
                            ❌
                        </span>
                    </a>
                <?php } ?>
                <a href="<?= $purchase->getURL(); ?>" title="" class="form-link">
                    <?= $purchase->getName(); ?>
                </a>
            </td>
            <td>
                <?php if ($paymentMethod) { ?>
                    <a href="<?= $paymentMethod->getURL(); ?>" title="">
                        <?= $paymentMethod->getName(); ?>
                    </a>
                <?php } else { ?>
                    ---
                <?php } ?>
            </td>
            <td>
                <?= $item->getAmountMoney()->formatByHtml(); ?>
            </td>
            <td>
                <?= $item->getStatus()->getLabelHTML(); ?>
            </td>
            <td>
                <div class="font-monospace bg-light">
                    <i class="fas fa-credit-card"></i>
                    <?= $item->card; ?>
                </div>
            </td>
            <td><?= $item->created; ?></td>
        </tr>
    <?php } ?>
    </tbody>
</table>

