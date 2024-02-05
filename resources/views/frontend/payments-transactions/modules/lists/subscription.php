<?php

use ByTIC\Money\Utility\Money;
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
                    <span class="text-danger" title="Not Processed">
                        ❌
                    </span>
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
                <?= Money::fromCents(intval($item->amount), $item->currency)->formatByHtml(); ?>
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

